<?php

namespace App\Controller;

use App\Repository\PlanRepository;
use App\Repository\ToolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(PlanRepository $planRepository, ToolRepository $toolRepository): Response
    {
        return $this->render('index/index.html.twig', [
            'plans' => $planRepository->findBy(['active' => true]),
            'tools' => $toolRepository->findBy(['isActive' => true]),
        ]);
    }
}
