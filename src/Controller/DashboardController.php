<?php

namespace App\Controller;


use App\Entity\Folder;
use App\Repository\FolderRepository;
use App\Repository\TaskRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;

final class DashboardController extends AbstractController
{
    function __construct(private LoggerInterface $logger){}


    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request, TaskRepository $taskRepository, FolderRepository $folderRepository, #[CurrentUser()] User $user): Response
    {   
        $user = $this->getUser();
        $status = $request->query->get('status');
        $priority = $request->query->get('priority');

        $tasks = $taskRepository->findByUserOrderedByPinned($user);

        if ($status) {
            $tasks = array_filter($tasks, fn($task) => $task->getStatus()->value === $status);
        }

        if ($priority) {
            $tasks = array_filter($tasks, fn($task) => $task->getPriority() && $task->getPriority()->getName() === $priority);
        }

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
            'currentStatus' => $status,
            'currentPriority' => $priority,
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

    public function taskByOrderedStatus(TaskRepository $taskRepository, FolderRepository $folderRepository): Response
    {
        $user = $this->getUser();

        $tasks = $taskRepository->findByUserOrderedByStatus($this->getUser());

        return $this->render('dashboard/index.html.twig', [
        'tasks'   => $tasks,
        'folders' => $folderRepository->findBy(['user' => $user]),    ]);
    }

}