<?php

namespace App\Form;

use App\Entity\Magasin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MagasinType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('nom', TextType::class, ["required" => false, "label" => "Nom", "attr" => ["placeholder" => "Saisir le nom"]])

      ->add('lienMap', TextType::class, ["required" => false, "label" => "ville", "attr" => ["placeholder" => "Saisir la ville"]])

      ->add('ville', TextType::class, ["required" => false, "label" => "lien", "attr" => ["placeholder" => "Saisir un mot clé de lien"]]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Magasin::class,
    ]);
  }
}
