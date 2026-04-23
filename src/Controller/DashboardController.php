<?php

namespace App\Controller;


use App\Entity\Folder;
use App\Repository\FolderRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(TaskRepository $taskRepository, FolderRepository $folderRepository): Response
    {
    $tasks = $taskRepository->findBy(['user' => $this->getUser()]);
    $folders = $folderRepository->findBy(['user' => $this->getUser()]);

    return $this->render('dashboard/index.html.twig', [
        'tasks' => $tasks,
        'folders' => $folders,
    ]);
    }
    
    #[Route('/dashboard/folder/{id}', name: 'app_dashboard_folder')]
    public function folder(Folder $folder, TaskRepository $taskRepository, FolderRepository $folderRepository): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'tasks' => $taskRepository->findBy(['folder' => $folder, 'user' => $this->getUser()]),
            'folders' => $folderRepository->findBy(['user' => $this->getUser()]),
            'currentFolder' => $folder,
            ]);
            }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function taskOrder(TaskRepository $taskRepository, FolderRepository $folderRepository): Response
    {
        $tasks = $taskRepository->findBy(['user' => $this->getUser()]);

        usort($tasks, function($a, $b) {
        $order = ['pending' => 0, 'completed' => 1, 'archived' => 2];
        return $order[$a->getStatus()->value] - $order[$b->getStatus()->value];
    });

        $folders = $folderRepository->findBy(['user' => $this->getUser()]);

        return $this->render('dashboard/index.html.twig', [
        'tasks' => $tasks,
        'folders' => $folders,
    ]);
    }
}