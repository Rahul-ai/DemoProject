<?php

namespace App\Controller;

use App\Entity\Attendence;
use App\Form\GetAttendence;
use App\Form\AttendenceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AttendanceController extends AbstractController
{
    #[Route('/attendance', name: 'attendance')]
    public function index(Request $request): Response
    {
        $Attendence = new Attendence();
        $form = $this->createForm(GetAttendence::class,$Attendence);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $newClass = $form->getData(); 
            $Date = new Date();
            $id = 1;
            
        $RAW_QUERY = 'SELECT a.Admission_Number,  FROM student a
        LEFT JOIN classes b ON a.class_id = $id  
        LEFT JOIN attendence c ON a.id = c.student_id AND c.Date = $Date
        GROUP BY a.id';

        $Attendance = $this->repo->RawQuery($RAW_QUERY);
    
        return $this->render('attendance/index.html.twig', [   
            'form' => $form->createView(),   
            'Addendance' => $Attendance
        ]);  
        }    
        return $this->render('attendance/index.html.twig', [   
            'form' => $form->createView(),
        ]);  
    }
}
