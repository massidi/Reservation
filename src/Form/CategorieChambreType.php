<?php

namespace App\Form;

use App\Entity\CategorieChambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categoryName', TextType::class, [

                'label'=>'Nom de la categorie',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'exampleInputEmail1',
                    // Add any other attributes you need here
                ],
            ])
            ->add('catdescription', TextType::class, [
                'label'=>'Description',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'exampleInputPassword1',
                    // Add any other attributes you need here
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieChambre::class,
        ]);
    }
}
