<?php

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

trait CommonRepositoryTrait
{
    /**
     * @param array|null $filters
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findCount(?array $filters = null): int
    {
        $queryBuilder = $this->createQueryBuilder('o')->select('count(o.id)');
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
