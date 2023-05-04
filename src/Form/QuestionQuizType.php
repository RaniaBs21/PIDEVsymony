<?php

namespace App\Form;

use App\Entity\QuestionQuiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class QuestionQuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descQuestion', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ question est obligatoire',
                    ]),
                ],
            ])
            ->add('idQuiz')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuestionQuiz::class,
        ]);
    }
}
