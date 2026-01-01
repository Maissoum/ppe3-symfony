<?php

namespace App\Form;

use App\Entity\Flm;
use App\Entity\Cat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FlmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => "Titre du film",
                'attr' => [
                    "placeholder" => "Titre du film",
                    "required" => true,
                    "minlength" => 2,
                    "maxlength" => 255
                ]
            ])

            ->add('description', TextareaType::class, [
                'label' => "Description",
                'required' => true,
                'attr' => [
                    "placeholder" => "Description du film",
                    "rows" => 4
                ]
            ])

            ->add('dateSorti', IntegerType::class, [
                'label' => "Année de sortie",
                'required' => true,
                'attr' => [
                    "placeholder" => "Ex : 2024",
                    "min" => 1900,
                    "max" => date('Y')
                ]
            ])

            ->add('duree', IntegerType::class, [
                'label' => "Durée (en minutes)",
                'required' => true,
                'attr' => [
                    "placeholder" => "Ex : 120",
                    "min" => 1
                ]
            ])

            ->add('image', TextType::class, [
                'label' => "Image (URL ou nom du fichier)",
                'required' => false,
                'attr' => [
                    "placeholder" => "ex : film.jpg ou https://..."
                ]
            ])

            ->add('cats', EntityType::class, [
                'class' => Cat::class,
                'choice_label' => 'nom',
                'label' => "Catégories",
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flm::class,
        ]);
    }
}