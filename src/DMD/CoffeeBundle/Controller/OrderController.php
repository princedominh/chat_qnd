<?php

namespace DMD\CoffeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use DMD\CoffeeBundle\Entity\Order;
use DMD\CoffeeBundle\Entity\OrderDetail;
use DMD\CoffeeBundle\Entity\OrderPrinted;
use DMD\CoffeeBundle\Form\Type\OrderDescriptionType;

class OrderController extends Controller
{
    public function indexAction()
    {
        $session = $this->get('session');
        $order_id = $this->getRequest()->get('order_id');
        
        $order = $this->getDoctrine()
                    ->getRepository('DMDCoffeeBundle:Order')
                    ->find($order_id);
        
        if ($order_id) {
            return $this->render('DMDCoffeeBundle:Order:detail.html.twig', 
                    array(
                        'order' => $order,
            ));
        } else {
        }
        
    }
    
    
    
    
    /**
     * Determine if date string is right format "d-m-Y h:i:s"
     * @param string $date
     * @return boolean
     */
    private function date_format($date)
    {
        if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4} ([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/",$date))
        {
            return true;
        }else{
            return false;
        }
    }

}
