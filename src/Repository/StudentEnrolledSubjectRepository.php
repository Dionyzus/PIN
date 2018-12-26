<?php

namespace App\Repository;

use App\Entity\StudentEnrolledSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StudentEnrolledSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentEnrolledSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentEnrolledSubject[]    findAll()
 * @method StudentEnrolledSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentEnrolledSubjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentEnrolledSubject::class);
    }

    // /**
    //  * @return StudentEnrolledSubject[] Returns an array of StudentEnrolledSubject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StudentEnrolledSubject
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
