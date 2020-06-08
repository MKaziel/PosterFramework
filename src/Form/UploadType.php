<?php

namespace App\Form;

use App\Entity\Upload;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('firstname', TextType::class)
            // le EmailType permet de vérifier si le champs à un email valide
            ->add('email', EmailType::class)
            ->add('mobile', TextType::class)
            // le ChoiceType permet de créer un select et de créer les options avec les choix "visibles" et les données qu'il renvoie
            ->add('building', ChoiceType::class, [
                'choices'  => [
                    'GeePs' => 1,
                    'Bat2' => 2,
                ]
            ])
            ->add('office', NumberType::class)
            ->add('file', FileType::class,array(
                'label' => 'Choisissez votre fichier'
            ))
            ->add('delivery_date', DateType::class, array(
                'widget' => 'single_text'))
            ->add('printing_format', ChoiceType::class, [
                'choices'  => [
                    'A0 (118,9 x 84,1 cm)' => 'A0 (118,9 x 84,1 cm)',
                    'A0+ oversize (129 x 91 cm)' => 'A0+ oversize (129 x 91 cm)',
                    'Other format' => 3
                ]
            ])
            ->add('printing_height', NumberType::class, ['required' => false])
            ->add('printing_weight', NumberType::class, ['required' => false])
            ->add('comment', TextareaType::class, ['required' => false])
            ->add('Submit',SubmitType::class)
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Upload::class,
        ]);
    }
}
