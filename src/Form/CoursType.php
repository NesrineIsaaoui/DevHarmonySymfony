<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Courscategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('coursname')
            ->add('coursdescription')
            ->add('coursimage',FileType::class,array("data_class"=>null))

            ->add('coursprix')
            ->add('idcategory', EntityType::class, [
                'class' => Courscategory::class,
                'choice_label' => 'categoryname',
                'choice_value' => 'categoryname',
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           // 'data_class' => Cours::class,
        ]);
    }
}
