<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Commentaire1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu')
            ->add('dateCommentaire', DateType::class, [
                'widget' => 'single_text', 
                'format' => 'yyyy-MM-dd',  
                'required' => true,       
                'attr' => ['placeholder' => 'Select a date'],
            ])
            ->add('publication')
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom', 
                'placeholder' => 'Select a user'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
