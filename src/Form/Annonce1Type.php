<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Categorie;
use PackageVersions\FallbackVersions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class Annonce1Type extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('titre', TextType::class, [
        "label" => "titre",
        "required" => false,
        "attr" => [
          "placeholder" => "Saisir le titre de l'annonce"
        ]
      ])
      ->add('description_courte', TextType::class, [
        "label" => "Description",
        "required" => "false",
        "attr" => [
          "placeholder" => "Saisir une description sommaire",
        ]
      ])
      ->add('description_longue', TextareaType::class, [
        "label" => "Explications",
        "required" => "false",
        "attr" => [
          "placeholder" => "Veuillez décrire votre produit en détail "
        ]
      ])
      ->add('prix', MoneyType::class, [
        "currency" => "EUR",
        //"label" => "Prix du produit",
        "required" => false,
        "attr" => [
          "placeholder" => "Saisir le prix du produit",
          "class" => "bg-light"
        ]
      ])
      ->add('adresse', TextType::class, [
        "label" => "Adresse du produit",
        "required" => false,
      ])


      ->add('cp', TextType::class, [
        "label" => "Code Postal",
        "required" => false,
      ])
      ->add('ville', TextType::class, [
        "label" => "Ville",
        "required" => false,
      ])
      ->add('categorie', EntityType::class, [
        "class" => Categorie::class,
        "choice_label" => "titre",
        //"mapped" => false,
      ]);;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Annonce::class,
      // Class "App\Form\CategorieType" seems not to be a managed Doctrine entity. Did you forget to map it?
    ]);
  }
}
