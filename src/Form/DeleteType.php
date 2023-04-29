<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('option1')
            ->add('option2')
            ->add('option3')
            ->add('option4')
            ->add('question')
            ->add('reponseCorrecte')
            ->add('id')
            ->add('delete', SubmitType::class, [
                'label' => 'Supprimer',
                'attr' => [
                    'onclick' => 'return confirm("Êtes-vous sûr de vouloir supprimer ce quiz ?");'
                ]
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
