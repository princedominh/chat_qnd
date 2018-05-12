<?php

namespace DMD\CoffeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use DMD\CoffeeBundle\Entity\Order;
use DMD\CoffeeBundle\Entity\OrderDetail;
use DMD\CoffeeBundle\Entity\OrderPrinted;
use DMD\CoffeeBundle\Form\Type\OrderDescriptionType;

class DefaultController extends Controller
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
    
    public function tableAction($table_alias)
    {
        $table = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Table')
                    ->findOneBy(array('alias'=>$table_alias));
        $items = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Item')
                    ->findAll();
        if ($table) {
            //find the current order
            $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->findOneBy(array('table' => $table->getId(), 'finished' => 0));
            return $this->render('DMDCoffeeBundle:Default:table.html.twig', 
                    array('table' => $table,
                        'order' => $order,
                        'items' => $items,
                    ));
        } else {
            return '';
        }
    }
    
    public function changeTableAction()
    {
        $table_source_id = $this->getRequest()->get('table_source');
        $table_destination_id = $this->getRequest()->get('table_destination');
        $order_id = $this->getRequest()->get('order');
        $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->find($order_id);
        if($order) {
            $table_source = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Table')
                    ->find($table_source_id);
             $table_destination = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Table')
                    ->find($table_destination_id);
            if($table_source) {
                if($table_destination) {
                    $order->setTable($table_destination);
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($order);
                    $em->flush();
                    $items = $this->getDoctrine()
                                ->getRepository('DMDCoffeeBundle:Item')
                                ->findAll();
                    return $this->render('DMDCoffeeBundle:Default:table.html.twig', 
                        array('table' => $table_destination,
                            'order' => $order,
                            'items' => $items,
                        ));
                }
            }
        }
        return new Response('error');
    }
    
    public function mergeTableAction()
    {
        $table_source_id = $this->getRequest()->get('table_source');
        $table_destination_id = $this->getRequest()->get('table_destination');
        $order_id = $this->getRequest()->get('order');
        $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->find($order_id);
        if($order) {
            $table_source = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Table')
                    ->find($table_source_id);
             $table_destination = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Table')
                    ->find($table_destination_id);
            if($table_source) {
                if($table_destination) {
                    $em = $this->getDoctrine()->getEntityManager();

                    $order_dest = $this->getDoctrine()
                        ->getRepository('DMDCoffeeBundle:Order')
                        ->findOneBy(array('table' => $table_destination->getId(), 'finished' => 0));
                    
                    $this->mergeOrder($order_dest, $order);
                    $em->persist($order_dest);
                    $em->remove($order);
                    $em->flush();
                    $items = $this->getDoctrine()
                                ->getRepository('DMDCoffeeBundle:Item')
                                ->findAll();
                    return $this->render('DMDCoffeeBundle:Default:table.html.twig', 
                        array('table' => $table_destination,
                            'order' => $order,
                            'items' => $items,
                        ));
                }
            }
        }
        return new Response('error');
    }

    public function createOrderAction($table_alias)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $table = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Table')
                    ->findOneBy(array('alias'=>$table_alias));
        if ($table) {
            //find the current order
            $order = new Order();
            $order->setTable($table);
            $table->setFinished(false);
            $em->persist($order);
            $em->persist($table);
            $em->flush();
            
            $items = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Item')
                    ->findAll();
            
            return $this->render('DMDCoffeeBundle:Default:order.html.twig', 
                    array('table' => $table,
                        'order' => $order,
                        'items' => $items,
                        ));
        } else {
            return new Response('error');
        }
    }
    
    public function addOrderDetailAction()
    {
        $order_id = $this->getRequest()->get('order');
        $item_id = $this->getRequest()->get('item');
        $quantity = $this->getRequest()->get('quantity');
        $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->find($order_id);
        $item = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Item')
                    ->find($item_id);
        if($order) {
            if($item) {
                $is_new = true;
                $orderDetails = $order->getOrderDetails();
                $em = $this->getDoctrine()->getEntityManager();
                //check if item is ordered
                foreach ($orderDetails as $detail){
                    if($detail->getItem()->getId()==$item_id) {
                        $is_new = false;
                        //just update quantity
                        $detail->setQuantity($detail->getQuantity()+$quantity);
                        $detail->setTotal($detail->getQuantity()*$item->getCurrentPrice());
//                        $em->persist($detail);
                        $em->flush();
                        break;
                    }
                }
                if($is_new) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->setItem($item);
                    $orderDetail->setOrder($order);
                    $orderDetail->setQuantity($quantity);
                    $orderDetail->setPrice($item->getCurrentPrice());
                    $orderDetail->setTotal($quantity*$item->getCurrentPrice());
                    $order->addOrderDetail($orderDetail);
                    $em->persist($orderDetail);
                    $em->flush();
                }
            }
        }
        
        return $this->render('DMDCoffeeBundle:Default:orderdetail.html.twig', 
                    array(
                        'order' => $order,
                        ));
    }
    
    public function removeOrderDetailAction()
    {
        $logger = $this->get('logger');
        
        $em = $this->getDoctrine()->getEntityManager();
        $order_detail_id = $this->getRequest()->get('order_detail_id');
        $orderDetail = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:OrderDetail')
                    ->find($order_detail_id);
        if($orderDetail) {
            $order = $orderDetail->getOrder();
            $logger->info('Order detail: '. $order->getOrderDetails()->count());
            $order->removeOrderDetail($orderDetail);
            $logger->info('Order detail: '. $order->getOrderDetails()->count());
            $em->remove($orderDetail);
            $em->flush();
            return $this->render('DMDCoffeeBundle:Default:orderdetail.html.twig', 
                    array(
                        'order' => $order,
                        ));
        } else {
            return new Response('error');
        }
    }
    
    
    public function saveOrderPrintedAction()
    {
        $order_id = $this->getRequest()->get('order_id');
        $content = $this->getRequest()->get('order_content');
        
        $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->find($order_id);

        $em = $this->getDoctrine()->getEntityManager();
        
        if($order) {
            $orderPrinted = new OrderPrinted();
            
            $orderPrinted->setOrder($order);
            $orderPrinted->setContent($content);
            $em->persist($orderPrinted);
            $em->flush();
            
            return new Response('ok');
        }
        
        return new Response('error');
    }
    
    public function saveOrderAction()
    {
        $order_id = $this->getRequest()->get('order_id');
        $orderRepository = $this->getDoctrine()->getRepository('DMDCoffeeBundle:Order');
        $order = $orderRepository->find($order_id);
        
        $em = $this->getDoctrine()->getEntityManager();
        
        if($order) {
            //check finish
            $order->setFinished(true);
            //count the total
            $order->setTotal($orderRepository->countTotal($order->getId()));
            
            $table = $order->getTable();
            $em->persist($order);
            $em->flush();
            return $this->render('DMDCoffeeBundle:Default:table.html.twig', 
                    array('table' => $table, 
                        'order' => null
            ));
            //reload Table information
        }
        
        return new Response('error');
    }
    
    public function addOrderDescriptionAction()
    {
        $request = $this->getRequest();
        $session = $this->get('session');
        $order = new Order();
        
        if ($request->isMethod('POST')) {
            $order_id = $this->getRequest()->get('order_id');
            $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->find($order_id);
            if($order) {
                $form = $this->createForm(new OrderDescriptionType(), $order);
                return $this->render('DMDCoffeeBundle:Default:description.html.twig', array(
                        'form' => $form->createView(),
                    ));                
            }
        }
        return $this->render('DMDCoffeeBundle:Default:description.html.twig', array(

            ));        
    }

    public function saveOrderDescriptionAction()
    {
        $request = $this->getRequest();
        $session = $this->get('session');
        $order = new Order();

        $form = $this->createForm(new OrderDescriptionType(), $order);

        if ($request->isMethod('POST')) {
            try {

                $form->bind($request);
                $data = $form->getData();
                $order_id = $data->getId();
                
                $em = $this->getDoctrine()->getManager();
                
                $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->find($order_id);
                if ($order) {
                    $em->persist($order);
                    $order->setDescription($data->getDescription());

                    $em->flush();
                } else {
                    return $this->render('DMDCoffeeBundle:Default:savedDescription.html.twig', array(
                        'error' => true,
                    ));
                }
                
            } catch (\Exception $e) {
                $session->getFlashBag()->add('dmd_flash_error', $e->getMessage());
                return $this->render('DMDCoffeeBundle:Default:savedDescription.html.twig', array(
                        'error' => true,
                    ));
            }
        }
        return $this->render('DMDCoffeeBundle:Default:savedDescription.html.twig', array(

            ));        
    }

    private function mergeOrder(Order &$order_dest, Order $order){
        $order_details = $order->getOrderDetails();
        $order_des_details = $order_dest->getOrderDetails();
        foreach($order_details as $detail) {
            $is_new = true;
            foreach($order_des_details as &$detail_des) {
                if($detail_des->getItem()->getId() == $detail->getItem()->getId()) {
                    $is_new = false;
                    $detail_des->setQuantity($detail_des->getQuantity()+$detail->getQuantity());
                    break;
                }
            }
            if($is_new) {
                $order_dest->addOrderDetail($detail);
            }
        }
    }
}
