<?php

namespace App\Form;

use App\Entity\CategorieCours;
use App\Entity\Cours;
use App\Entity\SousCategorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;



class SouscategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSc')
            
            ->add('CategorieCours',EntityType::class ,[
                'class'=> CategorieCours::class,
                'choice_label'=>'nomCat',
                'multiple'=>false,
                'expanded'=> false,
            ])

         
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousCategorie::class,
            'souscategorie' => null,
        ]);
    }
}