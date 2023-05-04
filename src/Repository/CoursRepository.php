<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 *
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    public function save(Cours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



public function finAllCours(): array{
    return $this ->createQueryBuilder('C')
    ->getQuery()
    ->getResult ()
    ;
}

public function findCoursByid($idC)
{
    return $this->createQueryBuilder('C')
        ->where('C.idC = :idC')
        ->setParameter('idC', $idC)
        ->getQuery()
        ->getOneOrNullResult();
}

public function findCours($titreC)
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.titreC LIKE :titreC')
        ->setParameter('titreC', '%' . $titreC . '%')
        ->getQuery()
        ->getResult();
}




public function findBySousCategorie($sousCategorie)
{
    return $this->createQueryBuilder('c')
        ->join('c.sousCategorie', 's')
        ->where('s.idSc = :sousCategorieId')
        ->setParameter('sousCategorieId', $sousCategorie)
        ->getQuery()
        ->getResult();
}



public function findCoursByTitre($titreC){
    return $this->createQueryBuilder("s")
       ->where('s.titre LIKE :titreC')
       ->setParameter('titre', '%'.$titreC.'%')
       ->getQuery()
       ->getResult();
    }


    public function findAllOrderedByTitle(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.titreC', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function getCoursesPerDay()
    {
        $queryBuilder = $this->createQueryBuilder('c')
        ->select('COUNT(c) as count', "DATE_FORMAT(c.dateC, '%Y-%m-%d') as date")

            ->groupBy('date')
            ->orderBy('date', 'DESC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }


    public function countBySousCategorie()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('sc.nomSc as sousCategorie, COUNT(c) as nbCours')
            ->join('c.sousCategorie', 'sc')
            ->groupBy('sousCategorie')
            ->getQuery();
    
        return $qb->getResult();
    }
    


}
