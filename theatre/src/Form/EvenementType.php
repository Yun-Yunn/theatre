<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('nbPlace')
            ->add('prix')
            ->add('description')
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'nomCategory', // Affiche le champ "nomCategory" dans le menu déroulant
                'placeholder' => 'Sélectionnez une catégorie', // Optionnel : ajout d’un choix vide par défaut
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
