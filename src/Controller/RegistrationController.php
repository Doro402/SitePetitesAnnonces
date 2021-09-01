<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
  private $emailVerifier;

  public function __construct(EmailVerifier $emailVerifier)
  {
    $this->emailVerifier = $emailVerifier;
  }

  /**
   * @Route("/register", name="app_register")
   */
  public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
  {
    $user = new User();
    $form = $this->createForm(RegistrationFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $hash = $encoder->hashPassword($user, $user->getPassword());
      //dd($user->getPassword());

      $user->setPassword($hash);
    //dd($user);
      $user->setDateEnregistrement(new \DateTimeImmutable('now'));
      //$manager = $this->getDoctrine()->getManager();
      $manager->persist($user);
      $manager->flush();


      // $hash = $encoder->hashPassword($user, $user->getPassword());

      // $user->setPassword($hash); // on redéfinit à la propriété password de l'obet user le mot de passe encodé avant l'envoie en bdd
      // $manager->persist($user);
      // $manager->flush();

      // generate a signed url and email it to the user
      $this->emailVerifier->sendEmailConfirmation(
        'app_verify_email',
        $user,
        (new TemplatedEmail())
          ->from(new Address('no-reply@annonceo.fr', 'Annonceo Mail Bot'))
          ->to($user->getEmail())
          ->subject('Veuillez confirmer votre email')
          ->htmlTemplate('registration/confirmation_email.html.twig')
      );
      // do anything else you need here, like send an email

      return $this->redirectToRoute('app_login');
    }

    return $this->render('registration/register.html.twig', [
      'registrationForm' => $form->createView(),
    ]);
  }


  /**
   * @Route("/verify/email", name="app_verify_email")
   */
  public function verifyUserEmail(Request $request): Response
  {
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    // validate email confirmation link, sets User::isVerified=true and persists
    try {
      $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    } catch (VerifyEmailExceptionInterface $exception) {
      $this->addFlash('verify_email_error', $exception->getReason());

      return $this->redirectToRoute('app_register');
    }

    // @TODO Change the redirect on success and handle or remove the flash message in your templates
    $this->addFlash('success', 'Votre email a bien été vérifié.');

    return $this->redirectToRoute('app_login');
  }
}
