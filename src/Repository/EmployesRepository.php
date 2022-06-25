<?php

namespace App\Repository;

use Exception;
use App\Entity\User;
use App\Entity\Employes;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Employes>
 *
 * @method Employes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employes[]    findAll()
 * @method Employes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployesRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;     
        parent::__construct($registry, Employes::class);
    }

    public function add(Employes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employes $entity, bool $flush = false): void
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

    public function AddEmployeAsUser(Employes $newEmployee)
    {
        try {
            $this->getEntityManager()->getConnection()->beginTransaction();
        
            //Add UserData
            $User = new User();
            $Algo = "@gmail.com";
            $UserName = $newEmployee->getName();
            $UserName = str_replace(" ","", $UserName); 
            $UserName = $UserName.$Algo;
            $User->setUserName($UserName);
            $User->setPassword(12345);
            $this->em->persist($User);
            $this->em->flush();

            //Add StudentData
            $newEmployee->setId($User->getId());
            $this->getEntityManager()->persist($newEmployee);
            $User = $this->getEntityManager()->flush();

            $this->getEntityManager()->getConnection()->commit();
        } 
        catch (Exception $e)
        {
            $this->getEntityManager()->getConnection()->rollback();
            throw $e;
        }
    }

//    /**
//     * @return Employes[] Returns an array of Employes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employes
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
