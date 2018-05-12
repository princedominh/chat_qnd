<?php

namespace DMD\CoffeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

//use DMD\CoffeeBundle\Entity\Order;
//use DMD\CoffeeBundle\Entity\OrderDetail;
//use DMD\CoffeeBundle\Entity\OrderPrinted;
//use DMD\CoffeeBundle\Entity\InventoryReceivingVoucher;

class InventoryController extends Controller
{
    public function indexAction()
    {
        $areas = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Area')
                    ->findAll();
        //get all table current order
        $em = $this->getDoctrine()->getEntityManager();
        foreach($areas as $area) {
            $tables = $area->getTables();
            foreach($tables as $table){
                $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->findOneBy(array('table' => $table->getId(), 'finished' => 0));
                if($order){
                    $table->setCurrentOrder($order);
                    if($table->getFinished()) {
                        $table->setFinished(false);
                        $em->persist($table);
                    }
                } else {
                    if(!$table->getFinished()) {
                        $table->setFinished(true);
                        $em->persist($table);
                    }                    
                }
            }
        }
        $em->flush();
        
        $items = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Item')
                    ->findAll();
        
        return $this->render('DMDCoffeeBundle:Default:index.html.twig', 
                array('areas' => $areas,
                    'items' => $items,
        ));
    }

}
