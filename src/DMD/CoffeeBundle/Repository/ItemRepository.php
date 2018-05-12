<?php

namespace DMD\CoffeeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DMD\CoffeeBundle\Entity\Category;

/**
 * Description of ItemRepository
 *
 * @author princedominh <princedominh@gmail.com>
 */
class ItemRepository extends EntityRepository{

    public function findAll() {
        $queryBuilder = $this->createQueryBuilder('i')
                ->orderBy('i.category')
            ;
        return $queryBuilder->getQuery()->getResult();
    }
    /**
     * 
     * @param \DMD\CoffeeBundle\Entity\Category $category
     * @param array $order
     * @return array
     */
    public function findAllItemInCategory(Category $category, array $order = null, $limit = null, $offset = null) {
        
        $queryBuilder = $this->createQueryBuilder('p')
                ->where('p.category in (:cats)')
                ->setParameter('cats', $this->getCategoryList($category));
        if ($order) {
            if (is_array($order)) {
                foreach ($order as $key => $value) {
                    $queryBuilder = $queryBuilder->orderBy('p.'.$key, $value);
                }
            }
        }
        if($limit)
        {
          $queryBuilder->setMaxResults($limit);
        }
        if($offset)
        {
          $queryBuilder->setFirstResult($offset);
        }

        $products = $queryBuilder->getQuery()->getResult();
        
        return $products;
    }
    
    public function findByKeyword($key, array $order = null, $limit = null, $offset = null) {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder
                ->where(
                    $queryBuilder->expr()->like('p.name', ':key')
                )
                ->orWhere(
                    $queryBuilder->expr()->like('p.description', ':key')
                )
                ->setParameter('key',"%$key%");
        if ($order) {
            if (is_array($order)) {
                foreach ($order as $k => $value) {
                    $queryBuilder = $queryBuilder->orderBy('p.'.$k, $value);
                }
            }
        }
        if($limit)
        {
          $queryBuilder->setMaxResults($limit);
        }
        if($offset)
        {
          $queryBuilder->setFirstResult($offset);
        }
        
        $products = $queryBuilder->getQuery()->getResult();
        
        return $products;
    }
    
    public function getAllQuantity($from_date, $to_date)
    {
        $queryBuilder = $this->createQueryBuilder('i');
        $queryBuilder
                ->select('i, sum(od.quantity) as quantity')
                ->innerJoin('i.order_details', 'od')
                ->where("od.createdAt > :from_date")
                ->andWhere("od.createdAt < :to_date")
                ->groupBy('od.item')
                ->setParameter('from_date',$from_date)
                ->setParameter('to_date',$to_date)
                ;
        return $queryBuilder->getQuery()->getResult();
    }
    
    private function getCategoryList(Category $category) {
        $categoriesArray = array($category);
        foreach ($category->getChildren() as $sub_category) {
            $categoriesArray = array_merge($categoriesArray, $this->getCategoryList($sub_category));
        }
        return $categoriesArray;
    }
}
