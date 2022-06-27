<?php

namespace App\DataFixtures;

use App\Entity\Student;
use App\Entity\Classes;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EntityFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $User = new Users();
        $Algo = "@gmail.com";
        $UserName = 'Admin';
        $Password = $UserName."@123";
        $UserName = $UserName.$Algo;
        $User->setemail($UserName);
        $User->setPassword(
        $this->userPasswordHasher->hashPassword(
            $User,
            $Password
        ));
        $User->setRoles(array('Admin'));   
        $manager->persist($User);
        $manager->flush();
    }
}
