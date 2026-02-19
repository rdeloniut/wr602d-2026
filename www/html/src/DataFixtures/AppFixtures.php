<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Plan;
use App\Entity\Tool;

use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //--- CREATION PLAN GRATUIT
        $planFree = new Plan();
        $planFree->setName('FREE');
        $planFree->setDescription('Abonnement gratuit');
        $planFree->setPrice(0);
        $planFree->setLimitGeneration(2);
        $planFree->setActive(true);
        //--- DONE - A REMPLACER PAR UN LIFECYCLE
        //$plan->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($planFree);

        //--- CREATION PLAN BASIC
        $planBasic = new Plan();
        $planBasic->setName('BASIC');
        $planBasic->setDescription('Abonnement basic - 20 générations par jour');
        $planBasic->setPrice(9.9);
        $planBasic->setLimitGeneration(20);
        $planBasic->setActive(true);
        $manager->persist($planBasic);

        //--- CREATION PLAN PREMIUM
        $planPremium = new Plan();
        $planPremium->setName('PREMIUM');
        $planPremium->setDescription('Abonnement PREMIUM - 200 générations par jour');
        $planPremium->setPrice(45);
        $planPremium->setLimitGeneration(200);
        $planPremium->setActive(true);
        $manager->persist($planPremium);

        //--- CREATION D'UN TOOL
        $tool = new Tool();
        $tool->setName('URL vers PDF');
        $tool->setSlug('url');
        $tool->setDescription('Convertissez une URL vers PDF');
        $tool->setColor('blue');
        $tool->setIcon('fa-solid fa-link');
        $tool->setIsActive(true);
        $tool->addPlan($planFree);
        $tool->addPlan($planBasic);
        $tool->addPlan($planPremium);

        $manager->persist($tool);

        //--- CREATION D'UN TOOL
        $tool = new Tool();
        $tool->setName('HTML vers PDF');
        $tool->setSlug('html');
        $tool->setDescription('Convertissez un fichier HTML vers PDF');
        $tool->setColor('pink');
        $tool->setIcon('fa-brands fa-html5');
        $tool->setIsActive(true);
        $tool->addPlan($planBasic);
        $tool->addPlan($planPremium);
        $manager->persist($tool);

        //--- CREATION D'UN TOOL
        $tool = new Tool();
        $tool->setName('Markdown vers PDF');
        $tool->setSlug('markdown');
        $tool->setDescription('Convertissez un fichier Markdown (.md) en PDF');
        $tool->setColor('purple');
        $tool->setIcon('fa-brands fa-markdown');
        $tool->setIsActive(true);
        $tool->addPlan($planBasic);
        $tool->addPlan($planPremium);
        $manager->persist($tool);

        //--- CREATION D'UN TOOL
        $tool = new Tool();
        $tool->setName('Office vers PDF');
        $tool->setSlug('office');
        $tool->setDescription('Convertissez vos documents Office (Word, Excel, PowerPoint) en PDF via LibreOffice');
        $tool->setColor('orange');
        $tool->setIcon('fa-solid fa-file-word');
        $tool->setIsActive(true);
        $tool->addPlan($planBasic);
        $tool->addPlan($planPremium);
        $manager->persist($tool);

        //--- CREATION D'UN TOOL
        $tool = new Tool();
        $tool->setName('Fusion de PDF');
        $tool->setSlug('merge');
        $tool->setDescription('Fusionnez plusieurs fichiers PDF en un seul document');
        $tool->setColor('green');
        $tool->setIcon('fa-solid fa-object-group');
        $tool->setIsActive(true);
        $tool->addPlan($planFree);
        $tool->addPlan($planBasic);
        $tool->addPlan($planPremium);
        $manager->persist($tool);

        //--- CREATION D'UN TOOL
        $tool = new Tool();
        $tool->setName('Capture d\'écran');
        $tool->setSlug('screenshot');
        $tool->setDescription('Capturez une page web en image (PNG) via Chromium');
        $tool->setColor('teal');
        $tool->setIcon('fa-solid fa-camera');
        $tool->setIsActive(true);
        $tool->addPlan($planPremium);
        $manager->persist($tool);

        $manager->flush();

    }
}
