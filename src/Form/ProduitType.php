<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idCatProd', null, [
                'label' => 'Catégorie du produit',
                'attr' => ['class' => 'form-control']
            ])
            ->add('typeProd', null, [
                'label' => 'Type de produit',
                'attr' => ['class' => 'form-control']
            ])
            ->add('descriptionProd', null, [
                'label' => 'Description du produit',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prixProd', null, [
                'label' => 'Prix du produit',
                'attr' => ['class' => 'form-control']
            ])
            ->add('url', FileType::class, [
                'data_class'=>null ,
                'label' => 'Choisir une image',
                'attr' => ['class' => 'form-control-file'],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}

