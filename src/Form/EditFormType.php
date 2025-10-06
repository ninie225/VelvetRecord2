<?php

namespace App\Form;

use App\Entity\Disc;
use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => true
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'mapped' => false,
                'multiple' =>false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG ou WEBP)',
                    ])
                ]
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année',
                'required' => true
            ])
            ->add('label', TextType::class, [
                'required' => true
            ])
            ->add('genre', TextType::class, [
                'required' => true
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'required' => true
            ])
            ->add('artist', EntityType::class, [
                'label' => 'Artiste',
                'class' => Artist::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disc::class,
            "attr" => [ "novalidate" => "novalidate"]
        ]);
    }
}
