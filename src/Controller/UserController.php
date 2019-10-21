<?php

namespace App\Controller;

use App\Entity\PasswordForgot;
use App\Entity\PasswordReset;
use App\Entity\PasswordUpdate;
use App\Entity\TokenPassword;
use App\Entity\User;
use App\Form\PasswordForgotType;
use App\Form\PasswordResetType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use App\Repository\TokenPasswordRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use function Sodium\crypto_pwhash_scryptsalsa208sha256;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    /**
     * @var TrickRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(TrickRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/profile", name="user.dashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $tricks = $this->repository->findAll();
        return $this->render('user/index.html.twig', compact('tricks'));
    }


    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $token = hash('sha256', date('Y/m/d H:i:s') . '_' . $user->getUsername());
            $user->setPassword($hash)
                ->setRole('ROLE_USER')
                ->setToken($token);
            $manager->persist($user);
            $manager->flush($user);

            $message = (new \Swift_Message('Bienvenue'))
                ->setFrom('josemadridgil90@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('emails/registration.html.twig', [
                        'username' => $user->getUsername(),
                        'token' => $user->getToken(),
                        'adress' => $_SERVER['SERVER_NAME'] . ':8000',
                    ]),
                    'text/html'
                );
            $mailer->send($message);


            $this->addFlash('success', 'Votre compte a bien été crée, un email vous a été envoyé de confirmation.\'');
            return $this->redirectToRoute('user_login');

        }

        return $this->render('user/registration.html.twig', [
            'form' => $form->createView()

        ]);


    }

    /**
     * @Route("/connexion", name="user_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/deconnexion", name="user_logout")
     */
    public function logout()
    {


    }

    /**
     * Forgot password
     *
     * @Route("/forgot-password", name="account_forgot")
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @param ObjectManager $manager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function forgotPassword(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer)
    {

        $passwordForgot = new PasswordForgot();
        $form = $this->createForm(PasswordForgotType::class, $passwordForgot);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(array('username' => $passwordForgot->getUsername()));
            if ($user) {

                $token = hash('sha256', date('Y/m/d H:i:s') . '_' . $user->getUsername());
                $message = (new \Swift_Message('Password Reset'))
                    ->setFrom('josemadridgil90@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView('emails/forgot-password.html.twig', [
                            'username' => $user->getUsername(),
                            'token' => $token,
                            'adress' => $_SERVER['SERVER_NAME'] . ':8000',
                        ]),
                        'text/html'
                    );
                $mailer->send($message);
                $tokenPassword = new TokenPassword();
                $tokenPassword->setToken($token)
                    ->setValid(true)
                    ->setExpirationDate(\DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s", strtotime('+24 hours'))))
                    ->setUser($user);
                $this->em->persist($tokenPassword);
                $this->em->flush();

                $this->addFlash('success', 'Un email vient de vous être envoyé pour réinitialiser votre mot de passe !');
                return $this->redirectToRoute('account_forgot');
            } else {
                $this->addFlash('danger', 'Cet utilisateur n\'existe pas.');
                return $this->redirectToRoute('account_forgot');
            }
        }
        return $this->render('account/forgot-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Reset password
     *
     * @Route("/reset-password", name="account_reset")
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resetPassword(UserRepository $userRepository, TokenPasswordRepository $tokenPasswordRepository, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $request = Request::createFromGlobals();
        if ($request->query->get('id')) {
            $id = $request->query->get('id');
        } else {
            $this->addFlash('danger', 'Lien non valide');

            return $this->redirectToRoute('account_forgot');
        }


        $passwordReset = new PasswordReset();
        $tokenPassword = $tokenPasswordRepository->findOneBy(array('token' => $id));
        if ($tokenPassword && $tokenPassword->getValid()) {
            $form = $this->createForm(PasswordResetType::class, $passwordReset);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $userRepository->findOneBy(array('id' => $tokenPassword->getUser()->getId()));
                if ($user) {
                    if ($user->getEmail() === $passwordReset->getEmail()) {
                        $newPassword = $passwordReset->getNewPassword();
                        $password = $encoder->encodePassword($user, $newPassword);
                        $user->setPassword($password);
                        $manager->persist($user);
                        $tokenPassword->setValid(false);
                        $manager->persist($tokenPassword);
                        $manager->flush();
                        $this->addFlash('success', 'Votre mot de passe a été mis à jour ! Connectez-vous !');
                        return $this->redirectToRoute('account_forgot');
                    }
                } else {
                    $this->addFlash('danger', 'Utilisateur non trouvé');

                    return $this->redirectToRoute('account_forgot');
                }
            }
            return $this->render('account/reset-password.html.twig', ['form' => $form->createView(),]);
        } else {
            $this->addFlash('danger', 'Lien non valide');

            return $this->redirectToRoute('account_forgot');
        }
    }


    /**
     * Update password
     *
     * @Route("profile/update-password", name="account_password")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $manager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public
    function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $passwordUpdate->getNewPassword();
            $password = $encoder->encodePassword($user, $newPassword);
            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre mot de passe a été mis à jour.');
            return $this->redirectToRoute('account_password');
        }
        return $this->render('account/update-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
