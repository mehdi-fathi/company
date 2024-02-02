<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUserRelatedCompany(int $user_id, int $company_id): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :i_user_id')
            ->andWhere('u.company_id = :i_company_id')
            ->setParameter('i_company_id', $company_id)
            ->setParameter('i_user_id', $user_id)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
