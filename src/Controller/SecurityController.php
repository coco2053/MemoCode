<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Mailer;
use App\Form\SignUpType;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_signup")
     */
    public function signUp(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, Mailer $mailer)
    {
        $user = new User();

        $form = $this->createForm(SignUpType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setConfirmationToken(bin2hex(random_bytes(32)));

            $manager->persist($user);

            $manager->flush();

            $title = 'Validation de votre compte sur MemoCode';
            $view = 'mail/signup.html.twig';
            $mailer->sendMail($user, $title, $view);

            $this->addFlash(
                'notice',
                'Un email vous a été envoyé à l\'adresse ' .$user->getEmail() . ' contenant un lien pour valider votre inscription. Pensez à vérifier votre courrier indésirable si vous ne le trouvez pas.'
            );

            return $this->redirectToRoute('articles_show');
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            return $this->render('security/signup_error.html.twig', [
                'form' => $form->createView()
            ]);
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/ajaxlogin", name="security_ajaxlogin", methods={"POST"})
     */
    public function ajaxlogin(Request $request)
    {
        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }
    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/validation/{token}", name="security_confirm")
     */
    public function validate(string $token, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        if (!\is_null($user = $userRepository->checkConfirmationToken($token))) {
            $user->setIsActive(true);
            $user->setConfirmationToken(null);

            $manager->persist($user);

            $manager->flush();

            $this->addFlash(
                'notice',
                'Votre compte est maintenant validé ! Vous pouvez désormais vous connecter.'
            );

            return $this->redirectToRoute('articles_show');
        }
        $this->addFlash(
            'notice',
            'La validation de votre compte a échoué. Peut être est-il déjà validé ?'
        );

        return $this->redirectToRoute('articles_show');
    }

    /**
     * @Route("/demande-changement-de-mdp", name="security_password_claim")
     */
    public function changePasswordClaim(Request $request, UserRepository $userRepository, EntityManagerInterface $manager, Mailer $mailer)
    {

        if (null !== $request->request->get('mail')) {
            $email = strip_tags($request->request->get('mail'));

            if (!\is_null($user = $userRepository->findOneBy(array('email' => $email)))) {
                $user->setPasswordToken(bin2hex(random_bytes(32)));

                $manager->persist($user);

                $manager->flush();

                $title = 'Demande de reinitialisation du mot de passe sur MemoCode';
                $view = 'mail/change_password.html.twig';
                $mailer->sendMail($user, $title, $view);

                $this->addFlash(
                    'notice',
                    'Un email vous a été envoyé à l\'adresse ' .$user->getEmail() . ' contenant un lien pour reinitialiser votre mot de passe. Pensez à vérifier votre courrier indésirable si vous ne le trouvez pas.'
                );

                return $this->redirectToRoute('articles_show');
            }
            $this->addFlash(
                'notice',
                'L\'adresse email ' .$email . ' n\'est pas enregistrée.'
            );

            return $this->redirectToRoute('articles_show');
        }
        return $this->render('security/change_password_claim.html.twig', [
        ]);
    }

    /**
     * @Route("/reinitialiser-mdp/{token}", name="security_change_password")
     */
    public function changePassword(Request $request, string $token, UserRepository $userRepository, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        if (!\is_null($user = $userRepository->checkPasswordToken($token))) {
            $form = $this->createForm(ChangePasswordType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setPasswordToken(null);

                $manager->persist($user);

                $manager->flush();

                $this->addFlash(
                    'notice',
                    'Votre mot de passe a bien été modifié !'
                );

                return $this->redirectToRoute('articles_show');
            }

            return $this->render('security/change_password.html.twig', [
                'form' => $form->createView()
            ]);
        }
        $this->addFlash(
            'notice',
            'Ticket de reinitialisation non valide. Veuillez refaire une demande.'
        );

        return $this->redirectToRoute('articles_show');
    }
}
