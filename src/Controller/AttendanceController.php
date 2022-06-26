<?php

namespace App\Controller;

use App\Entity\GetAtt;
use App\Entity\Attendence;
use App\Form\GetAttendence;
use App\Form\AttendenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AttendanceController extends AbstractController
{
    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em )
    {
        $this->em = $em;
        $this->repo = $this->em->getRepository(Attendence::class); 
    
    }
 
    #[Route('/attendance', name: 'attendance')]
    public function index(Request $request): Response
    {
       
        $form = $this->createForm(GetAttendence::class);
        
        $a = $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid())
        {
            $newClass = $form->getData("ClassId");
            $id = $newClass['ClassId']->getid(); 
            $Date = $newClass['Date'] ;
            
        $RAW_QUERY = 'SELECT a.id As student_id ,a.classs_id As class_id,c.status,c.date FROM student a
        LEFT JOIN classes b ON a.classs_id = b.id  
        LEFT JOIN attendence c ON a.id = c.student_id 
        Where a.classs_id = 1
        GROUP BY a.id';

        $Attendances = $this->repo->RawQuery($RAW_QUERY);
        dd($Attendances);
        $forms = array();
    
        foreach($Attendances as $Attendance)
        {
        $Attendence = new Attendence();
        $for = $this->createForm(AttendenceType::class,$Attendence);
        $forms[] = $for->createView();
        }
        return $this->render('attendance/index.html.twig', [   
            'form' => $form->createView(),   
            'forms' => $forms,
            'Addendance' => $Attendance
        ]);  
        }    

        return $this->render('attendance/index.html.twig', [   
            'form' => $form->createView(),
            'forms' => array()
        ]);  
    }
}
