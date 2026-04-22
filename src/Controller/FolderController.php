<?php

namespace App\Controller;

use App\Entity\Folder;
use App\Form\FolderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FolderController extends AbstractController
{
    #[Route('/folder/new', name: 'app_folder_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $folder = new Folder();
        $folder->setUser($this->getUser());
        $form = $this->createForm(FolderType::class, $folder);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('app_folder_index');
        }

        return $this->render('folder/index.html.twig', [
            'controller_name' => 'FolderController',
            'folder' => $folder,
            'form' => $form->createView(),
        ]);
    }
}
