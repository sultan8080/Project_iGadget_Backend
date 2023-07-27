<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;


#[Route('/api/reset-password')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private ManagerRegistry $doctrine;
    private ResetPasswordHelperInterface $resetPasswordHelper;
    private MailerInterface $mailer;

    public function __construct(
        ManagerRegistry $doctrine,
        ResetPasswordHelperInterface $resetPasswordHelper,
        MailerInterface $mailer
    ) {
        $this->doctrine = $doctrine;
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->mailer = $mailer;
    }

    #[Route('/forgot-password', name: 'api_forgot_password', methods: ['POST'])]
    public function forgotPassword(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;

        if (!$email) {
            return new JsonResponse(['message' => 'Email is required'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager = $this->doctrine->getManager();
        $user = $entityManager->getRepository(Users::class)->findOneBy(['email' => $email]);

        if (!$user) {

            return new JsonResponse(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            return new JsonResponse(['message' => 'Unable to generate reset token'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $email = (new TemplatedEmail())
            ->from(new Address('support@igadget.fr', 'IGadget'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ]);
        $this->mailer->send($email);

        return new JsonResponse(['message' => 'Password reset email sent']);
    }

    #[Route('/reset-password/{token}', name: 'api_reset_password', methods: ['POST', 'GET'])]
    public function resetPassword(Request $request, UserPasswordHasherInterface $passwordHasher, string $token): JsonResponse
    {
        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            return new JsonResponse(['message' => 'Invalid reset password token'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $password = $data['password'] ?? null;

        if (!$password) {
            return new JsonResponse(['message' => 'New password is required'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->resetPasswordHelper->removeResetRequest($token);
        $encodedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );


        // Set the new password for the user
        $user->setPassword($encodedPassword);
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Password reset successful']);
    }
}
