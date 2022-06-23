<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Form\ClassFormType;
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
        $Class = new Classes();
        $form = $this->createForm(ClassFormType::class,$Class);
        return $this->render('classes/index.html.twig', [
            'Classes' => $Classes,
            'form' => $form->createView()
        ]);
    }

    #[Route('/GetClassById/{Id}', name: 'GetClassById', methods:['GET'])]
    public function GetClassById($Id): Response
    {
        $Classes =  $this->repo->find($Id);
       
        return $this->render('classes/index.html.twig', [
            'Classes' => $Classes,
        ]);
    }

    #[Route('/PostClasses', name: 'PostClasses')]
    public function PostClasses(): Response
    {
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
