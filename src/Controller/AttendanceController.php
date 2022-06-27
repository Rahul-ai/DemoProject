<?php

namespace App\Controller;

use Exception;
use App\Entity\GetAtt;
use DateTimeInterface;
use App\Entity\Attendence;
use App\Form\GetAttendence;
use App\Form\AttendenceType;
use DateTime;
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
 
    #[Route('/GetAtten', name: 'GetAtten')]
    public function GetAtten(Request $request): Response
    {
       
        $form = $this->createForm(GetAttendence::class);       
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid())
        {
            $newClass = $form->getData("ClassId");
            $id = $newClass['ClassId']->getid(); 
            $Date = $newClass['Date'];
            $date = date_format($Date,"Y-m-d");    
        $RAW_QUERY = "SELECT c.Admission_Number,c.Name, a.Class_Name, b.Status FROM student c   
        LEFT JOIN attendence b ON c.id = b.Student_Id AND b.date = '$date'
        RIGHT JOIN classes a ON a.id = $id  
        GROUP BY c.id";

        $Attendances = $this->repo->RawQuery($RAW_QUERY);
        return $this->render('attendance/GetAttendance.html.twig', [   
            'form' => $form->createView(),   
            'Addendance' => $Attendances
        ]);  
        }    

        return $this->render('attendance/GetAttendance.html.twig', [   
            'form' => $form->createView(),
            'forms' => array(),
            'Addendance' =>array(),
        ]);  
    }

    #[Route('/SaveAttendance', name: 'SaveAttendance')]
    public function SaveAttendance(Request $request): Response
    {
        $form = $this->createForm(GetAttendence::class);       
        $form->handleRequest($request);
        $data = $request->request->all();
        $Student = $data['StudentId'];
        $Class = $data['ClassId'];
        $Status = $data['status'];
        $Date= $data['Date'];
        $Date = DateTime::createFromFormat('Y/m/d', $Date);
        if ($Date != null) {
            try {
                $this->em->getConnection()->beginTransaction();
                for ($i = 0; $i<count($Student); $i++) {
                    $Attendence = new Attendence();
                    $Attendence->setClassid($Class[$i]);
                    $Attendence->setStatus($Status[$i]);
                    $Attendence->setStudentid($Student[$i]);
                    $Attendence->setDate($Date);
            
                    $a = $this->em->persist($Attendence);
                    $a =$this->em->flush();
                }
            } catch (Exception $e) {
                dd($e);
                $this->em->getConnection()->rollback();
                return $this->redirectToRoute('attendance');
            }
            $this->em->getConnection()->commit();
        }
        return $this->redirectToRoute('attendance');
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
            $date = date_format($Date,"Y/m/d");    
            
        $RAW_QUERY = "SELECT c.Admission_Number,c.Name, a.Class_Name, a.id AS Class_id,c.id As Student_id, b.Status , b.Date FROM student c   
        LEFT JOIN attendence b ON c.id = b.Student_Id AND b.Date = '$date'
        RIGHT JOIN classes a ON a.id = c.classs_id     
        WHERE c.classs_Id = $id  
        GROUP BY c.id";

        $Attendances = $this->repo->RawQuery($RAW_QUERY);
    
        return $this->render('attendance/index.html.twig', [   
            'form' => $form->createView(),   
            'date' => $date,
            'Addendance' => $Attendances
        ]);  
        }    

        return $this->render('attendance/index.html.twig', [   
            'form' => $form->createView(),
            'forms' => array(),
            'Addendance' =>array(),
        ]);  
    }

}
