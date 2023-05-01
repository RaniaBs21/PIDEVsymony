<?php

namespace App\Form;

use App\Entity\QuestionAss;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class QuestionAssType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeQAss', null, [
                'label' => 'Question Type',
                'attr' => [
                    'placeholder' => 'Enter the question type',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'The question type must be at least {{ limit }} characters long',
                    ]),
                ],
            ])
            ->add('descriptionQAss', null, [
                'label' => 'Question Description',
                'attr' => [
                    'placeholder' => 'Enter the question description',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'The question description must be at least {{ limit }} characters long',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuestionAss::class,
        ]);
    }
}

