<?php

namespace App\Form;

use App\Entity\Sujet;
use App\Entity\Topic;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SujetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titresujet')
            ->add('contenu')
           

            /*->add('date', DateType::class, [
                'widget' => 'choice',
            ])*/

           /* ->add('accepter', ChoiceType::class, [
                'choices' =>[
                    'Option 0' => 0,
                    'Option 1' => 1,
                    
                ],
                'choice_label' => function($value, $key, $index) {
                    return $index;
                },
            ])*/

           /* ->add('idtopic',EntityType::class ,[
                'class'=> Topic::class,
                'choice_label'=>'idtopic',
                'multiple'=>false,
                'expanded'=> false,
            ])*/

            ->add('photo', FileType::class, [
                'label' => 'Choisir une image',
                'attr' => ['class' => 'form-control', 'id' => 'formFile'],
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
            ])
            ->add('ajouter',SubmitType::class)
            
            
            
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sujet::class,
        ]);
    }
}