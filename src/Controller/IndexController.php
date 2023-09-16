<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Importez les entités nécessaires
use App\Entity\Food;
use App\Entity\Meal;
use App\Form\FoodType;
use Doctrine\ORM\EntityManagerInterface;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function chooseFood(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FoodType::class);
        $meal = null; // Initialisation à null
        $selectedFoods = []; // Initialisez un tableau pour les aliments sélectionnés

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez les données du formulaire
            $formData = $form->getData();
            
            // Vérifiez quels aliments ont été sélectionnés
            $selectedFoods = $formData['selectedIngredients'];

            // Utilisez une méthode de correspondance pour trouver une recette correspondante
            $recipeName = $this->findMatchingRecipe($selectedFoods);

            if ($recipeName) {
                $meal = new Meal();
                $meal->setName($recipeName);
                $entityManager->persist($meal);

                // Associez les aliments sélectionnés au plat (meal) et enregistrez-les en base de données
                foreach ($selectedFoods as $foodName) {
                    $food = new Food();
                    $food->setName($foodName);
                    $food->setMeal($meal);
                    $entityManager->persist($food);
                }

                $entityManager->flush();
            }
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'meal' => $meal,
            'selectedFoods' => $selectedFoods,
        ]);
    }

    // ...

    // Fonction pour trouver une recette correspondante en fonction des ingrédients sélectionnés
    private function findMatchingRecipe($selectedFoods)
    {
        // Mettez en place la logique de correspondance des ingrédients et des recettes ici
        if (in_array('Chicken', $selectedFoods) && in_array('Tomato', $selectedFoods)) {
            return 'Basque chicken';
        }
        if (in_array('Beef', $selectedFoods) && in_array('Carrot', $selectedFoods) && in_array('Potatoe', $selectedFoods)) {
            return 'Beef bourguignon';
        }
        if (in_array('Tomato', $selectedFoods) && in_array('Potatoe', $selectedFoods)) {
            return 'Tomato soup';
        }
        if (in_array('Potatoe', $selectedFoods)&& in_array('Beef', $selectedFoods)) {
            return 'Steak and fries';
        }
        if (in_array('Egg', $selectedFoods)&& in_array('Milk', $selectedFoods) && in_array('Cheese', $selectedFoods)) {
            return 'Omelet';
        }
        if (in_array('Beef', $selectedFoods)&& in_array('Cheese', $selectedFoods) && in_array('Bread', $selectedFoods)) {
            return 'Cheeseburger';
        }

        // Ajoutez d'autres correspondances d'ingrédients et de recettes ici
        // Si aucune correspondance n'est trouvée, retournez null
        return null;
    }
}



