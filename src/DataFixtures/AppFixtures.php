<?php

namespace App\DataFixtures;

use App\Entity\Priority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $urgent = new Priority();
        $urgent->setName('urgent');
        $urgent->setImportance(3);
        $manager->persist($urgent);

        $important = new Priority();
        $important->setName('important');
        $important->setImportance(2);
        $manager->persist($important);

        $normal = new Priority();
        $normal->setName('normal');
        $normal->setImportance(1);
        $manager->persist($normal);

        $manager->flush();
    }
}
