<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Candidat;
use PackageVersions\FallbackVersions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CandidatType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('nom', TextType::class, [
        "label" => "nom",
        "required" => false,
        "attr" => [
          "placeholder" => "Saisir votre nom"
        ]
      ])
      ->add('prenom', TextType::class, [
        "label" => "prenom",
        "required" => "false",
        "attr" => [
          "placeholder" => "Saisir un prenom",
        ]
      ])
      ->add('email', TextType::class, [
        "label" => "email",
        "required" => "false",
        "attr" => [
          "placeholder" => "Veuillez décrire votre email "
        ]
      ])
      ->add('telephone', EntityType::class, [
        "class" => Candidat::class,
        "choice_label" => "telephone", 
      ])

      ->add('message', EntityType::class, [
        "class" => Candidat::class,
        "choice_label" => "message",
        
      ])
      ->add('cv', EntityType::class, [
        "class" => Candidat::class,
        "choice_label" => "cv",
       
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Candidat::class,
      // Class "App\Form\CategorieType" seems not to be a managed Doctrine entity. Did you forget to map it?
    ]);
  }
}
