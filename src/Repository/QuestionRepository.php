<?php

namespace App\Repository;

use App\Entity\QuestionQuiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<QuestionQuiz>
 *
 * @method QuestionQuiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionQuiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionQuiz[]    findAll()
 * @method QuestionQuiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionQuiz::class);
    }
    public function add(QuestionQuiz $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function save(QuestionQuiz $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(QuestionQuiz $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findOneBydescQuestion($descQuestion): ?QuestionQuiz
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.descQuestion = :val')
            ->setParameter('val', $descQuestion)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function TriBydescQuestion(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.descQuestion','ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()

            ;

}

    public function search(string $query)
    {
        $qb = $this->createQueryBuilder('q');

        $qb->where(
            $qb->expr()->orX(
                $qb->expr()->like('q.descQuestion', ':query'),
                $qb->expr()->like('q.choices', ':query')
            )
        )
            ->setParameter('query', '%'.$query.'%');

        return $qb->getQuery()->getResult();
    }
    public function searchByDesc(string $searchTerm)
    {
        $qb = $this->createQueryBuilder('qq');

        $qb->where('LOWER(qq.descQuestion) LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.strtolower($searchTerm).'%');

        return $qb->getQuery()->getResult();

}
    public function findByDescQuestion(string $query)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.descQuestion LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

}
