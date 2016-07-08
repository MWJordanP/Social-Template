<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findLikeUsername($term) {
        $builder = $this->createQueryBuilder('user')
            ->where('user.usernameCanonical LIKE :term')
            ->setParameter('term', '%'.$term)
            ->orderBy('user.username', "ASC")
            ->setMaxResults(10);
        
        return $builder->getQuery()->getResult();
    }
}