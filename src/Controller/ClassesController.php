<?php

namespace App\Controller;

use App\Entity\Classes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassesController extends AbstractController
{
    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em )
    {
        $this->em = $em;
        $this->repo = $this->em->getRepository(Classes::class); 
    
    }
 
    #[Route('/GetClasses', name: 'GetClasses')]
    public function GetClasses(): Response
    {
        $Classes =  $this->repo->findAll();
        dd($Classes);
        return $this->render('classes/index.html.twig', [
            'controller_name' => 'ClassesController',
        ]);
    }

    #[Route('/PostClasses', name: 'PostClasses')]
    public function PostClasses(): Response
    {
        $Classes =  $this->repo->count([]);
        dd($Classes);
        return $this->render('classes/index.html.twig', [
            'controller_name' => 'ClassesController',
        ]);
    }

    #[Route('/PutClasses', name: 'PutClasses')]
    public function PutClasses(): Response
    {
        $Classes =  $this->repo->findAll();
        dd($Classes);
        return $this->render('classes/index.html.twig', [
            'controller_name' => 'ClassesController',
        ]);
    }

    #[Route('/DeletedClasses', name: 'DeletedClasses')]
    public function DeletedClasses(): Response
    {
        $Classes =  $this->repo->findAll();
        dd($Classes);
        return $this->render('classes/index.html.twig', [
            'controller_name' => 'ClassesController',
        ]);
    }
}
