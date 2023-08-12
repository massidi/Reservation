<?php

namespace App\Form;

use App\Entity\CategorieChambre;
use App\Entity\Chambre;
use App\Entity\Equipement;
use App\Entity\Images;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ChambreType extends AbstractType
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('chamtype')
            ->add('chamdescription')
            ->add('prix')
            ->add('nbrlit')
//            ->add('CategorieChambre',EntityType::class,[
//
//            'class'=>CategorieChambre::class,
//                 'by_reference' => false,
//                    'expanded'=>true,
//                    'mapped'=>true,
//                    'multiple'=>false,
//                    'choice_label'=>'categoryName ',
//
//
//
//            ])


            ->add('CategorieChambre', ChoiceType::class, [
                'choices' => $this->getCategoryChoices(),
                'choice_label' => 'categoryName',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-select'
                ],
            ])


            ->add('Equipement', ChoiceType::class, [
                'choices' => $this->getEquipements(),
                'choice_label' => 'equipName',
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-select','multiple aria-label'=>"multiple"
                ],
                'data' => [],
            ])
//            ->add('Equipement',EntityType::class,[
//
//                'class'=>Equipement::class,
//                'by_reference' => false,
//                'expanded'=>true,
//                'mapped'=>true,
//                'multiple'=>true,
//                'choice_label'=>'equipName',
//
//               ])

//            ->add('Images', CollectionType::class, [
//                'entry_type' => ImagesType::class,
//                'allow_add' => true,
//                'allow_delete' => true,
//                'by_reference' => false,
//                'mapped'=>false,
//                'label' => 'Images',
//                'disabled'=>false
//            ]);

            ->add('Images', FileType::class, [
                'label' => false,
                'required' => false,
                'multiple' => true,
                'mapped' => false,
                'attr' => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }

    private function getCategoryChoices()
    {
        // Fetch the CategorieChambre entities from the database or any other source
        // and format them as choices for the select list

        $repository = $this->em->getRepository(CategorieChambre::class);
        $categories = $repository->findAll();

        $choices = [];
        foreach ($categories as $category) {
            $choices[$category->getId()] = $category;
        }

        return $choices;
    }

    private function getEquipements()
    {

        $repository = $this->em->getRepository(Equipement::class);
        $equipements = $repository->findAll();

        $choices = [];
        foreach ($equipements as $equipement) {
            $choices[$equipement->getId()] = $equipement;
        }

        return $choices;
    }
}
