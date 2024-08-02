<?php

namespace App\Controller;

use App\Entity\VacancyResume;
use App\Entity\VacancyResumeMark;
use App\Form\ResumeMarkType;
use App\Repository\VacancyResumeMarkRepository;
use App\Repository\VacancyResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/resume', name: 'resume_')]
class ResumeMarkController extends AbstractController
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly VacancyResumeRepository $resumeRepository,
        private readonly VacancyResumeMarkRepository $markRepository,
    ) {}

    #[Route(path: '/mark/list', name: 'mark_list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('resume-mark/list.html.twig', [
            'resumesMarks' => $this->markRepository->findAll()
        ]);
    }

    #[Route(
        path: '/{id}/mark/new',
        name: 'mark_new',
        requirements: ['resume' => '\d+'],
        methods: ['GET', 'POST']
    )]
    public function new(
        Request $request,
        VacancyResume $resume,
    ): Response
    {
        $resumeMark = new VacancyResumeMark();
        $form = $this->createForm(ResumeMarkType::class, $resumeMark);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resume->updateDate();

            $resumeMark->setResume($resume);
            $resumeMark->setUser($this->tokenStorage->getToken()->getUser());

            $this->resumeRepository->save($resume, true);
            $this->markRepository->save($resumeMark, true);

            return $this->redirectToRoute('resume_list');
        }

        return $this->render('resume-mark/new.html.twig', [
            'resume' => $resume,
            'vacancy' => $resume->getVacancy(),
            'form' => $form->createView(),
        ]);
    }
}
