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

            // Créez une nouvelle instance de Meal
            $meal = new Meal();
            
            // Vérifiez si "Poulet" et "Tomate" sont parmi les aliments sélectionnés
            if (in_array('Poulet', $selectedFoods) && in_array('Tomate', $selectedFoods)) {
                $meal->setName('Poulet Basque'); // Si les deux aliments sont sélectionnés, attribuez le nom "Poulet Basque" au plat
            } else {
                // Traitez d'autres cas de correspondance d'aliments et attribuez le nom approprié à Meal
            }

            // Enregistrez la nouvelle instance de Meal en base de données
            $entityManager->persist($meal);
            $entityManager->flush();

            // Associez les aliments sélectionnés au plat (meal) et enregistrez-les en base de données
            foreach ($selectedFoods as $foodName) {
                $food = new Food();
                $food->setName($foodName);
                $food->setMeal($meal); // Associez l'aliment au plat
                $entityManager->persist($food);
            }

            $entityManager->flush();

            // Redirigez l'utilisateur ou effectuez une autre action ici
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'meal' => $meal,
            'selectedFoods' => $selectedFoods,
        ]);
    }

    // ...
}





