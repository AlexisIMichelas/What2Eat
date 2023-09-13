<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Food;

class FoodFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créez l'enregistrement pour "Poulet"
        $poulet = new Food();
        $poulet->setName('Poulet');
        $manager->persist($poulet);

        // Créez l'enregistrement pour "Tomate"
        $tomate = new Food();
        $tomate->setName('Tomate');
        $manager->persist($tomate);

        $manager->flush();
    }
}
