<?php

namespace App\Controller;

use App\Entity\VacancyResume;
use App\Form\ResumeType;
use App\Repository\VacancyResumeRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/resume', name: 'resume_')]
class ResumeController extends AbstractController
{
    private ?Collection $allowedVacancies = null;

    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly VacancyResumeRepository $resumeRepository,
    ) {
        $this->checkAvailableVacancies();
    }

    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
    ): Response
    {
        $company = new VacancyResume();
        $form = $this->createForm(ResumeType::class, $company, ['allowed_vacancies' => $this->allowedVacancies]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->resumeRepository->save($company, true);

            return $this->redirectToRoute('resume_list');
        }

        return $this->render('resume/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/list', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('resume/list.html.twig', [
            'resumes' => $this->resumeRepository->findAll()
        ]);
    }

    #[Route(
        path: '/{id}/edit',
        name: 'edit',
        requirements: ['resume' => '\d+'],
        methods: ['GET', 'PUT', 'POST'])
    ]
    public function edit(
        Request $request,
        VacancyResume $resume,
    ): Response
    {
        if (!$this->allowedVacancies->contains($resume->getVacancy())) {
            return $this->redirectToRoute('resume_list');
        }

        $form = $this->createForm(ResumeType::class, $resume, ['allowed_vacancies' => $this->allowedVacancies]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resume->updateDate();
            $this->resumeRepository->save($resume, true);

            return $this->redirectToRoute('resume_list');
        }

        return $this->render('resume/edit.html.twig', [
            'resume' => $resume,
            'vacancy' => $resume->getVacancy(),
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        path: '/{id}/delete',
        name: 'delete',
        requirements: ['resume' => '\d+'],
        methods: ['GET']
    )]
    public function delete(VacancyResume $resume): Response
    {
        if ($this->allowedVacancies->contains($resume->getVacancy())) {
            $this->resumeRepository->remove($resume, true);
        }

        return $this->redirectToRoute('resume_list');
    }

    private function checkAvailableVacancies(): void
    {
        $this->allowedVacancies = $this->tokenStorage->getToken()->getUser()->getCompany()?->getVacancies();
    }
}
