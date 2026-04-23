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
        $color = $request->request->get('folder_color');
        $folder->setColor($color);
        $entityManager->persist($folder);
        $entityManager->flush();
        return $this->redirectToRoute('app_dashboard');
    }

    return $this->render('folder/new.html.twig', [
        'folder' => $folder,
        'form' => $form,
    ]);
}
}
