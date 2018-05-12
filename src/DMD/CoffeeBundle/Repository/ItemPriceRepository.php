<?php

namespace DMD\CoffeeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DMD\CoffeeBundle\Entity\Category;

/**
 * Description of ItemRepository
 *
 * @author princedominh <princedominh@gmail.com>
 */
class ItemPriceRepository extends EntityRepository{

    public function findNewestPrice($item_id) {
        $queryBuilder = $this->createQueryBuilder('p')
                ->select('p')
                ->innerJoin('p.item', 'i')
                ->setMaxResults(1)
                ->where('i.id=:item_id')
                ->setParameter('item_id',  $item_id)
                ;
        return $queryBuilder->getQuery()->getResult();
    }

}
