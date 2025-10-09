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
use Symfony\Component\Validator\Constraints\NotNull;

class DiscFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => true,
                'constraints' => [
                    new NotNull([], "Veuillez remplir le champ titre.")
                ]
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez uploader une image.'
                    ]),
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG ou WEBP)',
                    ])
                ]
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année',
                'required' => true,
                'constraints' => [
                    new NotNull([], "Veuillez remplir le champ année.")
                ]
            ])
            ->add('label', TextType::class, [
                'label' => 'Label',
                'required' => true,
                'constraints' => [
                    new NotNull([], "Veuillez remplir le champ label.")
                ]
            ])
            ->add('genre', TextType::class, [
                'label' => 'Genre',
                'required' => true,
                'constraints' => [
                    new NotNull([], "Veuillez remplir le champ genre.")
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'required' => true,
                'constraints' => [
                    new NotNull([], "Veuillez remplir le champ prix.")
                ]
            ])
            ->add('artist', EntityType::class, [
                'label' => 'Artiste',
                'class' => Artist::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotNull([], "Veuillez remplir le champ label.")
                ]
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
