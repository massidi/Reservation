<?php

namespace App\Controller\Admin;

use App\Entity\Rcommande;
use App\Form\RcommandeType;
use App\Repository\RcommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/restaurant_commande')]
class RcommandeController extends AbstractController
{
    #[Route('/', name: 'app_rcommande_index', methods: ['GET'])]
    public function index(RcommandeRepository $rcommandeRepository): Response
    {
        return $this->render('rcommande/index.html.twig', [
            'rcommandes' => $rcommandeRepository->findAll(),
        ]);
    }

    #[Route('/create_new_command"', name: 'app_rcommande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rcommande = new Rcommande();
        $form = $this->createForm(RcommandeType::class, $rcommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rcommande);
            $entityManager->flush();

            return $this->redirectToRoute('app_rcommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rcommande/new.html.twig', [
            'rcommande' => $rcommande,
            'form' => $form,
        ]);
    }

    #[Route('/view_command_detail/{id}', name: 'app_rcommande_show', methods: ['GET'])]
    public function show(Rcommande $rcommande): Response
    {
        return $this->render('rcommande/show.html.twig', [
            'rcommande' => $rcommande,
        ]);
    }

    #[Route('/edite_command/{id}', name: 'app_rcommande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rcommande $rcommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RcommandeType::class, $rcommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rcommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rcommande/edit.html.twig', [
            'rcommande' => $rcommande,
            'form' => $form,
        ]);
    }

    #[Route('/delete_command/{id}', name: 'app_rcommande_delete', methods: ['POST'])]
    public function delete(Request $request, Rcommande $rcommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rcommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rcommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rcommande_index', [], Response::HTTP_SEE_OTHER);
    }
}
