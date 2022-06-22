<?php

namespace App\DataFixtures;

use App\Entity\Classes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClassesFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $Classes1 = new Classes();
        $Classes1->setClassName('ClassI');
        
        $manager->persist($Classes1);

        $Classes2 = new Classes();
        $Classes2->setClassName('ClassII');
        
        $manager->persist($Classes2);

        $Classes2 = new Classes();
        $Classes2->setClassName('ClassIII');
        
        $manager->persist($Classes2);

        $Classes3 = new Classes();
        $Classes3->setClassName('ClassIV');
        
        $manager->persist($Classes3);

        $Classes4 = new Classes();
        $Classes4->setClassName('ClassV');
        
        $manager->persist($Classes4);

        $Classes5 = new Classes();
        $Classes5->setClassName('ClassVI');
        
        $manager->persist($Classes5);
       $manager->flush();

       $this->addReference('Classes_1',$Classes1);
       $this->addReference('Classes_2',$Classes2);
       $this->addReference('Classes_3',$Classes3);
       $this->addReference('Classes_4',$Classes4);
       $this->addReference('Classes_5',$Classes5);
    }
}
