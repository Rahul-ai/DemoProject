<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct($registry, Student::class);
    }

    public function add(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

     /**
     * @return Collection<array<string,mixed>>
     */
    public function RawQuery($RawQuery = null)
    {
        $statement = $this->getEntityManager()->getConnection()->prepare($RawQuery);
        return $statement->executeQuery()->fetchAllAssociative();   
    }

    public function AddStudentAsUser(Student $newStudent)
    {
        try {
            $this->getEntityManager()->getConnection()->beginTransaction();
        
            //Add UserData
            $User = new User();
            $Algo = "@gmail.com";
            $UserName = $newStudent->getName();
            $UserName = str_replace(" ","", $UserName); 
            $UserName = $UserName.$Algo;
            $User->setUserName($UserName);
            $User->setPassword(12345);
            $this->em->persist($User);
            $this->em->flush();

            //Add StudentData
            $newStudent->setId($User->getId());
            $this->getEntityManager()->persist($newStudent);
            $User = $this->getEntityManager()->flush();

            $this->getEntityManager()->getConnection()->commit();
        } 
        catch (Exception $e) {
            $this->getEntityManager()->getConnection()->rollback();
            throw $e;
        }
    }



//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
