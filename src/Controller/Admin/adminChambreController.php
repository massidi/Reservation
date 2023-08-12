<?php

namespace App\Controller\Admin;

use App\Entity\Chambre;
use App\Entity\Images;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use App\Repository\HotelRepository;
use App\Service\PictureHotelService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/chambre')]
class adminChambreController extends AbstractController
{
    #[Route('/', name: 'app_admin_chambre_index', methods: ['GET'])]
    public function index(ChambreRepository $chambreRepository): Response
    {
        return $this->render('admin/chambre/index.html.twig', [
            'chambres' => $chambreRepository->findAll(),
        ]);
    }

    #[Route('/create_room', name: 'app_admin_chambre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,HotelRepository $hotelRepository,PictureHotelService $pictureHotelService): Response
    {

        $hotels=$hotelRepository->findOneBy(['hotelnom' => "Sysinfocom"]);
        $chambre = new Chambre();

        $form = $this->createForm(ChambreType::class, $chambre);

        $form->handleRequest($request);

        $chambre->setHotel($hotels);

//        dd($chambre);


        if ($form->isSubmitted() && $form->isValid()) {

            $images= $form->get('Images')->getViewData();
            foreach ($images as $img)
            {
               $data[]= $img->getClientOriginalName();
            }




            dd($data);

            foreach ($images as $image){

                $folder = 'chambre';

//                $fichier =$pictureHotelService->add($image,$folder,300,300);

               $imageChambre = new Images();
               $imageChambre->setImageName($fichier);
               $imageChambre->setUpdatedAt(new \DateTimeImmutable());

               $chambre->addImage($imageChambre);

            }


            $entityManager->persist($chambre);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/chambre/new.html.twig', [
            'chambre' => $chambre,
            'form' => $form,
        ]);
    }

    #[Route('/view_room_details/{id}', name: 'app_admin_chambre_show', methods: ['GET'])]
    public function show(Chambre $chambre): Response
    {
        return $this->render('chambre/show.html.twig', [
            'chambre' => $chambre,
        ]);
    }

    #[Route('/edite_room/{id}/edit', name: 'app_admin_chambre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chambre $chambre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/chambre/edit.html.twig', [
            'chambre' => $chambre,
            'form' => $form,
        ]);
    }

    #[Route('/delete_room/{id}', name: 'app_admin_chambre_delete', methods: ['POST'])]
    public function delete(Request $request, Chambre $chambre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chambre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($chambre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_chambre_index', [], Response::HTTP_SEE_OTHER);
    }
}
