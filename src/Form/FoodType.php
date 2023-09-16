<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Importez le type SubmitType
use Symfony\Component\Form\FormBuilderInterface;

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('selectedIngredients', ChoiceType::class, [
                'label'    => 'Ingrédients',
                'required' => false,
                'choices'  => [
                    'Chicken' => 'Chicken',
                    'Tomato' => 'Tomato',
                    'Carrot' => 'Carrot',
                    'Potatoe' => 'Potatoe',
                    'Beef' => 'Beef',
                    'Egg' => 'Egg',
                    'Milk' => 'Milk',
                    'Cheese' => 'Cheese',
                    'Bread' => 'Bread',
                    // Ajoutez d'autres ingrédients ici si nécessaire
                ],
                'multiple' => true,
                'expanded' => true, // Permettre à l'utilisateur de sélectionner plusieurs ingrédients
            ])
            ->add('Valider', SubmitType::class); // Ajoutez le bouton de soumission directement ici
    }
}



