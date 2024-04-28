<?php

namespace App\Form;

use App\Entity\Publication;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class Publication1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('contenu')
            ->add('datePublication', DateType::class, [
                'widget' => 'single_text', 
                'format' => 'yyyy-MM-dd',  
                'required' => true,       
                'attr' => ['placeholder' => 'Select a date'],
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom', 
                'placeholder' => 'Select a user',
                'required' => true, 
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
