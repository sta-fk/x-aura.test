<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Vacancy;
use App\Form\VacancyType;
use App\Repository\VacancyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/vacancy', name: 'vacancy_')]
class VacancyController extends AbstractController
{
    private ?Company $company = null;

    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly VacancyRepository $repository,
    ) {
        $this->checkCompany();
    }

    #[Route(path: '/list', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        $vacancies = $this->company
            ? $this->repository->findBy(['company' => $this->company])
            : $this->repository->findAll()
        ;

        return $this->render('vacancy/list.html.twig', [
            'vacancies' => $vacancies
        ]);
    }

    #[Route(
        path: '/new',
        name: 'new',
        methods: ['GET', 'POST']
    )]
    public function new(
        Request $request,
    ): Response
    {
        $vacancy = new Vacancy();
        $vacancy->setCompany($this->company);
        $form = $this->createForm(VacancyType::class, $vacancy, ['company' => $this->company]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($vacancy, true);

            return $this->redirectToRoute('resume_list');
        }

        return $this->render('vacancy/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        path: '/{id}/delete',
        name: 'delete',
        requirements: ['vacancy' => '\d+'],
        methods: ['GET']
    )]
    public function delete(
        Vacancy $vacancy,
    ): Response
    {
        $this->repository->remove($vacancy, true);

        return $this->redirectToRoute('vacancy_list');
    }
    private function checkCompany(): void
    {
        $this->company = $this->tokenStorage->getToken()->getUser()?->getCompany();
    }
}
