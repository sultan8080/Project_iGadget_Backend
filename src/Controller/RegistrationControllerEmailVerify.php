<?php

namespace App\Controller;

use App\Entity\Users;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationControllerEmailVerify  extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;


    public function __construct(
        EmailVerifier $emailVerifier,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer

    ) {
        $this->emailVerifier = $emailVerifier;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    #[Route('/api/registration', name: 'api_register')]
    public function createUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        // Deserialize the JSON data into a Users object
        $user = $serializer->deserialize($request->getContent(), Users::class, 'json');

        // Validate the user entity
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return new Response(json_encode(['errors' => $errorMessages]), Response::HTTP_BAD_REQUEST);
        }

        // Set and hash the user's password
        $password = $data['password'] ?? '';
        $hashedPassword =  $userPasswordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(false);

        //Data inserting into database
        $entityManager->persist($user);
        $entityManager->flush();

        // generate a signed url and email it to the user
        $this->emailVerifier->sendEmailConfirmation(
            'api_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('no-reply@igadget.fr', 'iGadget'))
                ->to($user->getEmail())
                ->subject('Veuillez Confirmer votre email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
        return new Response('Votre compte à bien été crée, Veuillez vérifier vos emails pour l\'activer.', Response::HTTP_CREATED);
    }


    #[Route('/api/verify-email/', name: 'api_verify_email')]
    public function verifyEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = $request->query->get('id');
        $userRepository = $entityManager->getRepository(Users::class);
        $user = $userRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->redirectToRoute('email_verification_success');
        // return new JsonResponse(['message' => 'Email address verified'], Response::HTTP_OK);
    }

    #[Route('/email-verification/success', name: 'email_verification_success')]
    public function success(): Response
    {
        return $this->render('registration/EmailSuccess.html.twig');
    }
}
