<?php

namespace App\Form;

use App\Entity\Folder;
use App\Entity\Priority;
use App\Entity\Task;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            // ->add('status', EntityType::class, [
            //     'choices' => [
            //         'En cours' => 'pending',
            //         'Terminée' => 'completed',
            //         'Archivée' => 'archived',
            //     ]
            // ])
            ->add('folder', EntityType::class, [
                'class' => Folder::class,
                'choice_label' => 'name',
            ])
            ->add('isPinned')
            ->add('priority', EntityType::class, [
                'class' => Priority::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
