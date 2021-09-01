<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RegistrationFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('email', EmailType::class)
      ->add('conditions', CheckboxType::class, [
        'mapped' => false,
        'constraints' => [
          new IsTrue([
            'message' => "Veuillez accepter nos conditions d'utilisations.",
          ]),
        ],
      ])
      ->add('password', RepeatedType::class, [
        'type'=> PasswordType::class, 
        'first_name'=>"first",
        'required'=>false,  
        'second_name'=>'second',
        'invalid_message'=>"Les mots de passe ne sont pas identiques",
        'first_options'=>[
          "label"=>'Mot de passe',
        ],
        'second_options'=>[
          "label"=>"Confirmation de votre mot de passe",
        ],
          'attr' => ['autocomplete' => 'new-password'],
          'constraints' => [
            new NotBlank([
              'message' => 'Veuillez rentrer votre mot de passe',
            ]),
            new Length([
              'min' => 8,
              'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
              // max length allowed by Symfony for security reasons
              'max' => 30,
            ]),
          ],
        ]
      )

      ->add('pseudo', TextType::class, [
        "required" => false,
        "label" => "Pseudo"
      ])
      ->add('nom', TextType::class, [
        "required" => true,
        "label" => "Nom"
      ])

      ->add('prenom', TextType::class, [
        "required" => true,
        "label" => "Prénom"
      ])

      ->add('adresse', TextType::class, [
        "required" => false,
        "label" => "Adresse"
      ])

      ->add('ville', TextType::class, [
        "required" => false,
        "label" => "Ville"
      ])

      ->add('telephone', TelType::class, [
        "required" => false,
        "label" => "Téléphone"
      ])
      ->add('cp', TextType::class, [
        "required" => false,
        "label" => "Code Postal",

      ])
      ->add('civilite', TextType::class, [
        "required" => false,
        "label" => "Civilité"
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
