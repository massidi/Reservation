<?php

namespace App\Form;

use App\Entity\Equipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipName', TextType::class, [
                'label' => 'Equipment Name',  // Set the label text for the 'equipName' field
                'attr' => [
                    'class' => 'form-control',
                    // Add any other attributes you need here
                ],
            ])
            ->add('equipdescription', TextType::class, [
                'label' => 'Equipment Description',  // Set the label text for the 'equipdescription' field
                'attr' => [
                    'class' => 'form-control',
                    // Add any other attributes you need here
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipement::class,
        ]);
    }
}
