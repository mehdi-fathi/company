<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
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

    /**
     * @param string $name
     * @param int $companyId
     * @param string $role
     * @return void
     */
    public function create(string $name, int $companyId, string $role)
    {
        // Create a new User entity
        $user = new User();
        $user->setName($name);

        $user->setCompanyId($companyId);
        $user->setRole($role);

        $this->persistEntity($user);

    }

    /**
     * @param \App\Entity\User $user
     * @return void
     */
    private function persistEntity(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param $userId
     * @return void
     */
    public function delete($userId): void
    {
        $entity = $this->findOneBy(['id' => $userId]);

        if ($entity) {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        }

    }

}
