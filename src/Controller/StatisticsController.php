<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics', name: 'statistics_')]
class StatisticsController extends AbstractController
{
    public function __construct(
        private readonly StatisticsService $service,
    ) {}

    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('statistics/index.html.twig', [
            'rating' => $this->service->getResumeRating()
        ]);
    }
}
