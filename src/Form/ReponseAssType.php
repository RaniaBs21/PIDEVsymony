<?php

namespace App\Form;

use App\Entity\ReponseAss;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ReponseAssType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('typeRepAss')
        ->add('queRepAss', null, [
            'constraints' => [
                new NotBlank([
                    'message' => 'The question field cannot be empty',
                ]),
                new Length([
                    'min' => 3,
                    'max' => 255,
                    'minMessage' => 'The question field should be at least {{ limit }} characters',
                    'maxMessage' => 'The question field should not be longer than {{ limit }} characters',
                ]),
            ],
        ])
        ->add('descriptionRepAss')
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseAss::class,
        ]);
    }
}
