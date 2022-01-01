<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Candidat;
use PackageVersions\FallbackVersions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;





class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('cv', CvType::class, [
                'label' => 'cv (PDF file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Cv([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            
        ;
    }

   
} 

