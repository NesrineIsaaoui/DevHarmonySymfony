<?php

namespace App\Form;
use DateTime;
use App\Entity\Task;
use App\Entity\Plan; // Import the Plan entity
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Import ChoiceType
use Symfony\Component\Form\Extension\Core\Type\DateTimeType; // Import DateType
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomcour')
            ->add('date', DateTimeType::class,) // Use DateTimeType for date input
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Not Started' => 'not started',
                    'In Progress' => 'in progress',
                    'Done' => 'done',
                ],
                'placeholder' => 'Etat', // Optional placeholder
            ])
            ->add('idplan', ChoiceType::class, [ // Configure idplan as a choice type field
                'choices' => $options['plans'], // Pass available plans as choices
                'choice_label' => 'nom', // Display the 'nom' property of the Plan entity as choice label
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'plans' => [], // Define a default empty array for available plans
        ]);
    }
}

