<?php

namespace App\DataFixtures;

use App\Entity\Pin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $pin1 = new Pin();
            $pin1->setTitle('Titre 1');
            $pin1->setDescription('Description 1');
            $manager->persist($pin1);

            $pin2 = new Pin();
            $pin2->setTitle('Titre 2');
            $pin2->setDescription('Description 2');
            $manager->persist($pin2);

            $pin3 = new Pin();
            $pin3->setTitle('Titre 3');
            $pin3->setDescription('Description 3');
            $manager->persist($pin3);

        $manager->flush();
    }
}
