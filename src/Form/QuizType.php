<?php
namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5, 'max' => 50]),
                ],
            ])
            ->add('question', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ question est obligatoire',
                    ]),
                ],
            ])
            ->add('option1', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ option1 est obligatoire',
                    ]),
                ],
            ])
            ->add('option2', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ option2 est obligatoire',
                    ]),
                ],
            ])
            ->add('option3', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ option3 est obligatoire',
                    ]),
                ],
            ])
            ->add('option4', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ option4 est obligatoire',
                    ]),
                ],
            ])
            ->add('reponseCorrecte', ChoiceType::class, [
                'choices' => [
                    'Option 1' => 'option1',
                    'Option 2' => 'option2',
                    'Option 3' => 'option3',
                    'Option 4' => 'option4',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La réponse correcte est obligatoire',
                    ]),
                    new Choice([
                        'choices' => ['option1', 'option2', 'option3', 'option4'],
                        'message' => 'La réponse correcte doit être une des valeurs suivantes : option1, option2, option3, option4',
                    ]),
                ],
            ])


            ->getForm();

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}

