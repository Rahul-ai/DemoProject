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
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid())
        {
            $newClass = $form->getData("ClassId");
            $id = $newClass['ClassId']->getid(); 
            $Date = $newClass['Date'];
            $Date = date_format($Date,"Y/m/d");    
            
        $RAW_QUERY = "SELECT c.Admission_Number,c.Name, a.Class_Name, a.id AS Class_id,c.id As Student_id, b.Status , b.Date FROM student c   
        LEFT JOIN attendence b ON c.id = b.Student_Id AND b.Date = '$Date'
        RIGHT JOIN classes a ON a.id = c.classs_id     
        WHERE c.classs_Id = $id  
        GROUP BY c.id";

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
