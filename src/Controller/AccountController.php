<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ChangePassword;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ProfileType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormError;

class AccountController extends AbstractController
{
    /**
     * Log the user in and manage the connection form.
     *
     * @Route("/login", name="account_login")
     *
     * @param AuthenticationUtils $utils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $errors = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('Account/login.html.twig', [
            'hasErrors' => null !== $errors,
            'username' => $username,
        ]);
    }

    /**
     * Used by Symfony for logging the user out.
     *
     * @Route("/logout", name="account_loggout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/new-account", name="account_registration")
     *
     * @param Request                      $request The request object
     * @param EntityManagerInterface       $manager The entity manager
     * @param UserPasswordEncoderInterface $encoder The password encoder
     *
     * @return Response The response object
     */
    public function register(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Use the encoder to encrypt the password
                $hash = $encoder->encodePassword($user, $user->getHash());
                // Set the encrypted password instead of the plain one
                $user->setHash($hash);
                //<editor-fold desc="Persisting the user in the database">

                $manager->persist($user);
                $manager->flush();

                //</editor-fold>
                // add some flash message for success
                $this->addFlash(
                    'success',
                    'The registration has been successfully saved'
                );
                // Redirecting to some route
                return $this->redirectToRoute('account_login');
            }
        }

        return $this->render('Account/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Security("is_granted('IS_QUIS_AUTHENTICATED_FULLY')")
     *
     * Edits the profile.
     *
     * @Route("/profile", name="account_profile")
     *
     * @param Request                $request
     * @param EntityManagerInterface $manager
     *
     * @return Response
     */
    public function profile(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $manager->flush();
            }
        }

        return $this->render('Account/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * Updates the user's password.
     *
     * @Route("/update-password", name="account_password")
     *
     * @param Request                      $request The request object
     * @param EntityManagerInterface       $manager The entity manager
     * @param UserPasswordEncoderInterface $encoder The password encoder
     * @return Response
     */
    public function password(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $password = new ChangePassword();
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $password);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $newHash = $encoder->encodePassword($user, $password->getNewPassword());
                $user->setHash($newHash);
                $manager->flush();

                return $this->redirectToRoute('account_loggout');
            }
        }

        return $this->render(
            'Account/password.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
