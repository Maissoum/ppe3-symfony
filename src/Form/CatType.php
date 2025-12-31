<?php

namespace App\Form;

use App\Entity\Cat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom de la catégorie",
                'attr' => [
                    "placeholder" => "Nom de la catégorie",
                    "required" => true,
                    "minlength" => 2,
                    "maxlength" => 50
                ]
            ])

            ->add('description', TextareaType::class, [
                'label' => "Description",
                'required' => true,   // ← empêche NULL dans la BDD
                'attr' => [
                    "placeholder" => "Décrire la catégorie",
                    "rows" => 3
                ]
            ])

            ->add('couleur', TextType::class, [
                'label' => "Couleur (RGB ou Hexa)",
                'required' => false,
                'attr' => [
                    "placeholder" => "ex : #ff0055 ou 255,0,0"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}
