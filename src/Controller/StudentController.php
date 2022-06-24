<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentTypeFormType;
use App\Form\StudentTypeForm;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
        $this->repo = $em->getRepository(Student::class);
    }

    #[Route('/GetStudent', name: 'GetStudent')]
    public function GetAllStudent(Request $request): Response
    {

        $Raw_Query ='SELECT a.admission_number, a.id, a.Name, c.class_name  From student a 
        LEFT JOIN classes c ON c.id = a.classs_id
        GROUP BY a.id';

        $Student = new Student();
        $form = $this->createForm(StudentTypeFormType::class,$Student);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $newStudent = $form->getData();
            $this->em->persist($newStudent);
            $this->em->flush();
            return $this->redirectToRoute('GetStudent');
        }
        
        $Students = $this->repo->RawQuery($Raw_Query);

        return $this->render('student/index.html.twig', [
            'form' => $form->createView(),
            'Students' => $Students,
        ]);
    }

    #[Route('/PutStudent/{Id}', name: 'PutStudent')]
    public function PutStudent(Request $request,$Id): Response
    {
        $Student =  $this->repo->findOneBy(['id'=>$Id]);
        
        $form = $this->createForm(StudentTypeFormType::class,$Student);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $Student = $form->getData();
            $this->em->flush();
            return $this->redirectToRoute('GetStudent');
        }

        return $this->render('student/editstudent.html.twig', [
            'form'=> $form->createView(),
        ]);
    }


    #[Route('/DeletedStudent/{Id}', name: 'DeletedStudent')]
    public function DeletedClasses($Id): Response
    {
        $Student =  $this->repo->findOneBy(['id'=>$Id]);
        $this->repo->remove($Student);
        $this->em->flush();
        return $this->redirectToRoute('GetStudent');
    }
}
