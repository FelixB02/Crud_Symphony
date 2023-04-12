<?php

namespace App\Form;

use App\Entity\Todo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Grades;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;



class TodoType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
      $builder
          ->add('name', TextType::class, [
              'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;']
          ])
          ->add('picture', FileType::class, [
            'label' => 'Picture (Image File)',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpg',
                        'image/jpeg',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ])
            ],
            'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;']
          ])
          ->add('age', NumberType::class, [
              'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;']
          ])
          ->add('skills', ChoiceType::class, [
              'choices' => ['Insane' => 'Insane', 'Pretty Good' => 'Pretty Good', 'Average' => 'Average', 'Trash' => 'Trash', 'Mad Trash' => 'Mad Trash'],
              'attr' => ['class' => 'form-select', 'style' => 'margin-bottom:15px;']
          ])
          ->add('iq', NumberType::class, [
               'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;']
          ])
          ->add('alias', TextType::class, [
               'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;']
          ])
          ->add('fk_grades', EntityType::class, [
            'class' => Grades::class,
            'choice_label' => 'avg_grade',
            'attr' => ['class' => 'form-select', 'style' => 'margin-bottom:15px;']
          ])
          ->add('save', SubmitType::class, [
              'label' => 'Submit',
              'attr' => ['class' => 'btn btn-outline-success mybtn', 'style' => 'margin-bottom:15px;']
          ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'data_class' => Todo::class,
      ]);
  }
}