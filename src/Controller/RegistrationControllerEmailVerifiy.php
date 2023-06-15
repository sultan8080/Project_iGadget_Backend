<?php

namespace App\Controller;


use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationControllerEmailVerifiy  extends AbstractController
{
    private EmailVerifier $emailVerifier;
    public function __construct(
        EmailVerifier $emailVerifier,
    ) {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
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
        return new Response('User created successfully', Response::HTTP_CREATED);
    }
}
