<?php

namespace App\Controller;

// ...

use App\Entity\Food;
use App\Entity\Meal;
use App\Form\FoodType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function chooseFood(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FoodType::class);
        $meal = null; // Initialisation à null

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez les données du formulaire
            $formData = $form->getData();
            
            // Vérifiez quels ingrédients ont été sélectionnés
            $selectedIngredients = $formData['selectedIngredients'];

            // Créez une nouvelle instance de Meal
            $meal = new Meal();
            
            // Vérifiez si "Poulet" et "Tomate" sont parmi les ingrédients sélectionnés
            if (in_array('Poulet', $selectedIngredients) && in_array('Tomate', $selectedIngredients)) {
                $meal->setName('Poulet Basque'); // Si les deux ingrédients sont sélectionnés, attribuez le nom "Poulet Basque" au plat
            } else {
                // Traitez d'autres cas de correspondance d'ingrédients et attribuez le nom approprié à Meal
            }

            // Enregistrez la nouvelle instance de Meal (ou faites ce que vous voulez avec elle)
            $entityManager->persist($meal);
            $entityManager->flush();

            // Redirigez l'utilisateur ou effectuez une autre action ici
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'meal' => $meal,
        ]);
    }

    // ...
}





