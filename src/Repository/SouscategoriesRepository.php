<?php

namespace App\Repository;

use App\Entity\Cours;
use App\Entity\SousCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SousCategorie>
 *
 * @method SousCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousCategorie[]    findAll()
 * @method SousCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SouscategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousCategorie::class);
    }

    public function save(SousCategorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SousCategorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
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


public function finAllSouscategories(): array{
    return $this ->createQueryBuilder('C')
    ->getQuery()
    ->getResult ()
    ;
}



public function finAll(): array{
    return $this ->createQueryBuilder('d')
    ->getQuery()
    ->getResult ()
    ;
}



public function countByCategorie()
{
    $qb = $this->createQueryBuilder('c')
        ->select('sc.nomCat as categorieCours, COUNT(c) as nbCategorie')
        ->join('c.categorieCours', 'sc')
        ->groupBy('categorieCours')
        ->getQuery();

    return $qb->getResult();
}
}