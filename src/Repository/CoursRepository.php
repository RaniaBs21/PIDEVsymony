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
       ->where('s.titreC LIKE :titreC')
       ->setParameter('titreC', '%'.$titreC.'%')
       ->getQuery()
       ->getResult();
    }








//afficher un etudiant a partir d'un id de classroom
public function ListStudentByClass($id)
{
return $this->createQueryBuilder(alias: 's')
->join(join: 's.classroom',alias: 'c')
->addSelect(select: 'c')
->where(predicates:'c.id=:id')
->setParameter('id',$id)
->getQuery()
->getResult();

}


public function findAllOrderByEmail()
{
    return $this->createQueryBuilder('s')
        ->orderBy('s.email', 'ASC')
        ->getQuery()
        ->getResult();
}



public function findStudentByNsc($nsc)
{
    return $this->createQueryBuilder('s')
        ->where('s.nsc = :nsc')
        ->setParameter('nsc', $nsc)
        ->getQuery()
        ->getOneOrNullResult();
}


public function searchByNsc($nsc)
{
    $qb = $this->createQueryBuilder('s');
    $qb->where('s.nsc LIKE :nsc')
       ->setParameter('nsc', '%' . $nsc . '%');
    return $qb->getQuery()->getResult();
}


public function findLastThree()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.creation_date', 'DESC')
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();
}

}