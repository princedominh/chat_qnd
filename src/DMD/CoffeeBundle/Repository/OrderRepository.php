<?php

namespace DMD\CoffeeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DMD\CoffeeBundle\Entity\Category;

/**
 * Description of OrderRepository
 *
 * @author princedominh <princedominh@gmail.com>
 */
class OrderRepository extends EntityRepository{
    
    public function findByDates($from_date, $to_date) {
        
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder
                ->where("o.createdAt > :from_date")
                ->andWhere("o.createdAt < :to_date")
                ->setParameter('from_date',$from_date)
                ->setParameter('to_date',$to_date)
                ;
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function countTotal($order_id)
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder
               ->select('sum(od.total) as dtotal')
                ->innerJoin('o.order_details','od')
                ->where("o.id = :order_id")
                ->setParameter('order_id', $order_id)
                ;
        $result = $queryBuilder->getQuery()->getResult();
        if (is_array($result)) {
            return $result[0]['dtotal'];
        }
    }
}
