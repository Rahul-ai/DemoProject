<?php

namespace App\Controller;

use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    private $em;
    private $repo;
    function __construct(EntityManagerInterface $em )
    {
        $this->em = $em;
        $this->repo = $em->getRepository(EmployesRepository::class);
    }

    #[Route('/GetStudent', name: 'GetStudent',methods:['GET'])]
    public function GetAllStudent(): Response
    {
        
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
}
