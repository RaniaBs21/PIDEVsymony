<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\SousCategorie;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrueValidator as ConstraintsIsTrueValidator;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;






class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreC',TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5, 'max' => 50]),
                ],
            ])
            
            ->add('SousCategorie',EntityType::class ,[
                'class'=> SousCategorie::class,
                'choice_label'=>'nomSc',
                'multiple'=>false,
                'expanded'=> false,
            ])

            ->add('niveauC', ChoiceType::class, [
                'choices' => [
                    'Option 0' => 0,
                    'Option 1' => 1,
                    'Option 2' => 2,
                    'Option 3' => 3,
                ],
                'choice_label' => function($value, $key, $index) {
                    return $index;
                },
            ])
            ->add('fichierC', FileType::class, [
                'data_class'=>null,
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
           
          
            ->add('descriptionC', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'style' => 'height: 100px'],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('prix');
           
            $builder->add('captcha', CaptchaType::class, array(
                'width' => 200,
                'height' => 50,
                'length' => 6,
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
            'cours' => null,
        
        ]);
    }
}