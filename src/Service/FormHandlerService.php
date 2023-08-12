<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;


class FormHandlerService
{
    private EntityManagerInterface $entityManager;
    private FormFactoryInterface $formFactory;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function processForm(Request $request, $entity, $formType): bool
    {
        $form = $this->formFactory->create($formType, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return true;
        }

        return false;
    }

    public function getEntityById($entityClass, $id)
    {
        return $this->entityManager->getRepository($entityClass)->find($id);
    }

    public function getFormView()
    {
    }
}