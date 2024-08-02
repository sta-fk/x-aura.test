<?php

namespace App\Controller;

use App\Entity\VacancyResume as Resume;
use App\Form\ResumeType;
use App\Repository\VacancyResumeRepository as ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/resume', name: 'resume_')]
class ResumeController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        ResumeRepository $repository,
    ): Response
    {
        $company = new Resume();
        $form = $this->createForm(ResumeType::class, $company);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($company, true);

            return $this->redirectToRoute('resume_list');
        }

        return $this->render('resume/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/list', name: 'list', methods: ['GET'])]
    public function list(
        ResumeRepository $repository,
    ): Response
    {
        return $this->render('resume/list.html.twig', [
            'resumes' => $repository->findAll()
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
        Resume $resume,
        ResumeRepository $repository,
    ): Response
    {
        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resume->setUpdatedAt(new \DateTimeImmutable('now'));
            $repository->save($resume, true);

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
    public function delete(
        Resume $resume,
        ResumeRepository $repository,
    ): Response
    {
        $repository->remove($resume, true);

        return $this->redirectToRoute('resume_list');
    }
}
