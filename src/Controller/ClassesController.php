<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Form\ClassFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function GetClasses(Request $request): Response
    {
        $Class = new Classes();
        $form = $this->createForm(ClassFormType::class,$Class);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $newClass = $form->getData();    
            $this->em->persist($newClass);
            $this->em->flush();  
            return $this->redirectToRoute('GetClasses');
        }

        $RAW_QUERY = 'SELECT a.id, a.class_name, COUNT(c.Id) AS Student_Count FROM classes a 
        LEFT JOIN student c ON c.id = a.id
        GROUP BY a.id';
        
        $statement = $this->em->getConnection()->prepare($RAW_QUERY);
        $Classes = $statement->executeQuery()->fetchAllAssociative();
        return $this->render('classes/index.html.twig', [
            'Classes' => $Classes,
            'form' => $form->createView() ]);
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

    #[Route('/PutClasses/{Id}', name: 'PutClasses')]
    public function PutClasses(Request $request,$Id): Response
    {
        $Class =  $this->repo->findOneBy(['id'=>$Id]);
        
        $form = $this->createForm(ClassFormType::class,$Class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $Class->class_name = $form->getData("Class_Name");
            $this->em->flush();
            return $this->redirectToRoute('GetClasses');
        }
        return $this->render('classes/EditClass.html.twig', [
            'form'=> $form->createView(),
        ]);
    }

    #[Route('/DeletedClasses/{Id}', name: 'DeletedClasses')]
    public function DeletedClasses($Id): Response
    {
        $Class =  $this->repo->findOneBy(['id'=>$Id]);
        $Classes = $this->repo->remove($Class);
        $this->em->flush();
        return $this->redirectToRoute('GetClasses');
    }
}
