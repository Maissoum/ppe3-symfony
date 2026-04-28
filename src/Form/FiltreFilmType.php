<?php

namespace App\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreFilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => false,
                'required' => false,
                'attr'=> [
                    'class' => 'form-control form-control-lg',
                    "placeholder" => "🔍 Titre du film... ",
                    "required" => true,
                    "minlength" => 2,
                    "maxlength" => 255 ]  
            ])
             ->add('Rechercher', Submit::class, [
                'label' => "Rechercher",
                ])
            
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
