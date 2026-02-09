<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Plan;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //--- CREATION PLAN GRATUIT
        $plan = new Plan();
        $plan->setName('FREE');
        $plan->setDescription('Abonnement gratuit');
        $plan->setPrice(0);
        $plan->setLimitGeneration(2);
        $plan->setActive(true);
        //--- DONE - A REMPLACER PAR UN LIFECYCLE
        //$plan->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($plan);

        //--- CREATION PLAN BASIC
        $plan = new Plan();
        $plan->setName('BASIC');
        $plan->setDescription('Abonnement basic - 20 générations par jour');
        $plan->setPrice(9.9);
        $plan->setLimitGeneration(20);
        $plan->setActive(true);
        $manager->persist($plan);

        //--- CREATION PLAN PREMIUM
        $plan = new Plan();
        $plan->setName('PREMIUM');
        $plan->setDescription('Abonnement PREMIUM - 200 générations par jour');
        $plan->setPrice(45);
        $plan->setLimitGeneration(200);
        $plan->setActive(true);
        $manager->persist($plan);

        $manager->flush();
    }
}
