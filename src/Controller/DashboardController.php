<?php

namespace App\Controller;


use App\Entity\Folder;
use App\Repository\FolderRepository;
use App\Repository\TaskRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;

final class DashboardController extends AbstractController
{
    function __construct(private LoggerInterface $logger){}


    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(TaskRepository $taskRepository, FolderRepository $folderRepository, #[CurrentUser()] User $user): Response
    {   
        $user = $this->getUser();
        $tasks = $taskRepository->findByUserOrderedByPinned($user);

        usort($tasks, function ($a, $b) {
            if ($a->isPinned() === $b->isPinned()) {
                return $a->isPinned() ? -1 : 1;;
            }
            $order = ['pending' => 0, 'completed' => 1, 'archived' => 2];
            return $order[$a->getStatus()->value] - $order[$b->getStatus()->value];
        });

        $folders = $folderRepository->findBy(['user' => $user]);

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

    // #[Route('/dashboard', name: 'app_dashboard')]
    // public function taskOrder(TaskRepository $taskRepository, FolderRepository $folderRepository): Response
    // {
    //     $tasks = $taskRepository->findBy(['user' => $this->getUser()]);

    //     usort($tasks, function($a, $b) {
    //     $order = ['pending' => 0, 'completed' => 1, 'archived' => 2];
    //     return $order[$a->getStatus()->value] - $order[$b->getStatus()->value];
    // });

    //     $folders = $folderRepository->findBy(['user' => $this->getUser()]);

    //     return $this->render('dashboard/index.html.twig', [
    //     'tasks' => $tasks,
    //     'folders' => $folders,
    // ]);
    // }

    public function taskByOrderedPinned(TaskRepository $taskRepository, FolderRepository $folderRepository): Response
    {
        $user = $this->getUser();

        $tasks = $taskRepository->findByUserOrderedByPinned($this->getUser());
        $this->logger->info("HAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA");
        $this->logger->info(json_encode($tasks));
        return $this->render('dashboard/index.html.twig', [
        'tasks'   => $tasks,
        'folders' => $folderRepository->findBy(['user' => $user]),    ]);
    }
}