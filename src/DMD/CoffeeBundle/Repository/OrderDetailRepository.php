<?php

namespace DMD\CoffeeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DMD\CoffeeBundle\Entity\Category;

/**
 * Description of OrderDetailRepository
 *
 * @author princedominh <princedominh@gmail.com>
 */
class OrderDetailRepository extends EntityRepository{

    public function getAllQuantity($from_date, $to_date)
    {
        $queryBuilder = $this->createQueryBuilder('od');
        $queryBuilder
                ->select('i.name, sum(od.quantity) as quantity, i.current_price, i.current_cost')
                ->leftJoin('od.item', 'i')
                ->where("od.createdAt > :from_date")
                ->andWhere("od.createdAt < :to_date")
                ->groupBy('i.id')
                ->setParameter('from_date',$from_date)
                ->setParameter('to_date',$to_date)
                ;
        return $queryBuilder->getQuery()->getResult();
    }
    
}
