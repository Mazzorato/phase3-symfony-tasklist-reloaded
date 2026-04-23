<?php

namespace App\Controller;


use App\Entity\Priority;
use App\Form\PriorityType;
use App\Repository\PriorityRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PriorityController extends AbstractController
{
    #[Route('/priority', name: 'app_priority')]
    public function new(Request $request, EntityManagerInterface $entityManager, PriorityRepository $priorityRepository): Response
    {
        $priority = new Priority();
        $form = $this->createForm(PriorityType::class, $priority);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $priority->setImportance($priorityRepository->count([]) + 1);
            $entityManager->persist($priority);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard');
        }
        
        return $this->render('priority/index.html.twig', [
        'form' => $form,
        'priorities' => $priorityRepository->findAll(),
    ]);
    }
}
