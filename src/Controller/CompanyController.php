<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company', name: 'company_')]
class CompanyController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        CompanyRepository $repository,
    ): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($company, true);

            return $this->redirectToRoute('company_list');
        }

        return $this->render('company/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/list', name: 'list', methods: ['GET'])]
    public function list(
        CompanyRepository $repository,
    ): Response
    {
        return $this->render('company/list.html.twig', [
            'companies' => $repository->findAll()
        ]);
    }

    #[Route(
        path: '/{id}/edit',
        name: 'edit',
        requirements: ['company' => '\d+'],
        methods: ['GET', 'PUT', 'POST'])
    ]
    public function edit(
        Request $request,
        Company $company,
        CompanyRepository $repository,
    ): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($company, true);

            return $this->redirectToRoute('company_list');
        }

        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        path: '/{id}/delete',
        name: 'delete',
        requirements: ['company' => '\d+'],
        methods: ['GET']
    )]
    public function delete(
        Company $company,
        CompanyRepository $repository,
    ): Response
    {
        $repository->remove($company, true);

        return $this->redirectToRoute('company_list');
    }
}
