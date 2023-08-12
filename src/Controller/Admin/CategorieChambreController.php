<?php

namespace App\Controller\Admin;

use App\Entity\CategorieChambre;
use App\Form\CategorieChambreType;
use App\Repository\CategorieChambreRepository;
use App\Service\FormHandlerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin_categorie_chambre')]
class CategorieChambreController extends AbstractController
{
    private FormHandlerService $formHandlerService;

    public function __construct(FormHandlerService $formHandlerService)
    {


        $this->formHandlerService = $formHandlerService;
    }

    #[Route('/', name: 'app_admin_categorie_chambre_index', methods: ['GET'])]
    public function index(CategorieChambreRepository $categorieChambreRepository): Response
    {
        return $this->render('admin/categorie_chambre/index.html.twig', [
            'categorie_chambres' => $categorieChambreRepository->findAll(),
        ]);
    }

    #[Route('/create_new_categorie', name: 'app_admin_categorie_chambre_new', methods: ['GET', 'POST'])]
    public function new(Request $request,CategorieChambre $categorieChambre): Response
    {


        $entityType = CategorieChambreType::class;


        if ($this->formHandlerService->processForm($request, $categorieChambre, $entityType)) {

            return $this->redirectToRoute('app_admin_categorie_chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categorie_chambre/new.html.twig', [
            'categorie_chambre' => $categorieChambre,
            'form' => $this->createForm($entityType, $categorieChambre),
        ]);
    }


    #[Route('/{id}', name: 'app_admin_categorie_chambre_show', methods: ['GET'])]
    public function show(CategorieChambre $categorieChambre): Response
    {
        return $this->render('admin/categorie_chambre/show.html.twig', [
            'categorie_chambre' => $categorieChambre,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_admin_categorie_chambre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieChambre $categorieChambre, EntityManagerInterface $entityManager): Response
    {


        $entityType = CategorieChambreType::class;


        if ($this->formHandlerService->processForm($request, $categorieChambre, $entityType)) {

            return $this->redirectToRoute('app_admin_categorie_chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categorie_chambre/edit.html.twig', [
            'categorie_chambre' => $categorieChambre,
            'form' => $this->createForm($entityType, $categorieChambre),
        ]);
    }



    #[Route('/{id}', name: 'app_admin_categorie_chambre_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieChambre $categorieChambre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categorieChambre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieChambre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_categorie_chambre_index', [], Response::HTTP_SEE_OTHER);
    }
}
