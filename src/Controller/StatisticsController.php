<?php

namespace App\Controller;

use App\Entity\VacancyResume;
use App\Entity\VacancyResumeMark;
use App\Form\ResumeMarkType;
use App\Repository\VacancyResumeMarkRepository;
use App\Repository\VacancyResumeRepository;
use App\Service\StatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
