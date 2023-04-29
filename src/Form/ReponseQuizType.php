<?php

namespace App\Form;

use App\Entity\ReponseQuiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseQuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('option1')
            ->add('option2')
            ->add('option3')
            ->add('option4')
            ->add('reponseCorrecte')
            ->add('idQuest')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseQuiz::class,
        ]);
    }
}
