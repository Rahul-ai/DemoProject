<?php

namespace App\Repository;

use App\Entity\Attendence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Attendence>
 *
 * @method Attendence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attendence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attendence[]    findAll()
 * @method Attendence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attendence::class);
    }

    public function add(Attendence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Attendence $entity, bool $flush = false): void
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

//    /**
//     * @return Attendence[] Returns an array of Attendence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Attendence
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
