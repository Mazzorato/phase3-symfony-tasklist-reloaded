<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findBy([
            'user' => $this->getUser()], ['id' => 'DESC']);
        return $this->render('dashboard/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
