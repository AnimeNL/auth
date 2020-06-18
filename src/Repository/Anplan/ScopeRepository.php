<?php

namespace App\Repository\Anplan;

use App\Entity\Anplan\Scope;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Scope|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scope|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scope[]    findAll()
 * @method Scope[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScopeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scope::class);
    }

    /**
     * @return Scope[]
     */
    public function findActive(): array
    {
        return $this->findBy(['active' => 1]);
    }

    /**
     * @return Scope[]
     */
    public function getUserScopes(int $userId, array $scopes): array
    {
        $qb = $this->createQueryBuilder('s');
        $scopesConditions = [];
        foreach ($scopes as $i => $scope) {
            $scopesConditions[] = $qb->expr()->like('s.scope', ":scope$i");
            $qb->setParameter("scope$i", $scope.'%');
        }
        $qb
            ->where('s.active = 1')
            ->andWhere('s.user = :user')
            ->setParameter('user', $userId)
            ->andWhere($qb->expr()->orX(...$scopesConditions));

        return $qb->getQuery()->getResult();
    }
}
