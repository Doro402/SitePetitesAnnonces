<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Magasin;
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
          "placeholder" => "Saisir le titre de l'offre"
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
      ->add('categorie', EntityType::class, [
        "class" => Categorie::class,
        "choice_label" => "titre",
        //"mapped" => false,
      ])

      ->add('magasin', EntityType::class, [
        "class" => Magasin::class,
        "choice_label" => "nom",
        //"mapped" => false,
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Annonce::class,
      // Class "App\Form\CategorieType" seems not to be a managed Doctrine entity. Did you forget to map it?
    ]);
  }
}
