<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

     /**
      * @return User[] Returns an array of User objects
      */

    public function findByFirstName($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.firstname LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByLastName($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.lastname LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByEmail($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByUserTag($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.usertag LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByPhoneNumber($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.phone_number LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }



    public function SortByFirstName()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function SortByEmail()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function SortByUserTag()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.usertag', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function SortByPhoneNumber()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.phone_number', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }




    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
