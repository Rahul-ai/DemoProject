<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Employes;
use App\Form\EmployeFormType;
use App\Form\EmployeTypeFormType;
use App\Form\StudentTypeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeeController extends AbstractController
{
    private $em;
    private $repo;
    function __construct(EntityManagerInterface $em )
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Student::class);
    }

    #[Route('/GetEmployee', name: 'GetEmployee')]
    public function GetAllEmployee(Request $request): Response
    {
        $Employee = new Employes();
        $form = $this->createForm(EmployeTypeFormType::class,$Employee);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $newEmployee = $form->getData();
            $this->repo->AddEmployeAsUser($newEmployee);
            $this->em->flush();
            return $this->redirectToRoute('GetEmployee');
        }
        
        $Employes = $this->repo->findAll();

        return $this->render('employee/index.html.twig', [
            'form' => $form->createView(),
            'Employes' => $Employes,
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
