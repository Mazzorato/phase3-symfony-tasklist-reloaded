<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    //    /**
    //     * @return Task[] Returns an array of Task objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Task
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByUserOrderedByPinned(User $user): array
    {
        return $this->createQueryBuilder('task')
            ->andWhere('task.user = :user')
            ->setParameter('user', $user)
            ->orderBy('task.isPinned', 'DESC')
            ->addOrderBy('task.id', 'ASC')
            ->getQuery()
            ->getResult();

        // return $this->createQueryBuilder("task")
        //         ->select('task')
        //         ->from("Task","task")
        //         ->getQuery()
        //         ->getArrayResult();
    }
}