<?php

namespace DMD\CoffeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use DMD\CoffeeBundle\Entity\Order;
use DMD\CoffeeBundle\Entity\OrderDetail;
use DMD\CoffeeBundle\Entity\OrderPrinted;
use DMD\CoffeeBundle\Form\Type\OrderDescriptionType;

class AnalysisController extends Controller
{
    public function indexAction()
    {
        $session = $this->get('session');
        
        $from_date = $this->getRequest()->get('from_date');
        $to_date = $this->getRequest()->get('to_date');
        if (!$from_date) {
            $from_date = date("Y-m-d") . " 00:00:00";
            $to_date = date("Y-m-d") . " 23:59:59";
        } else {
            if ($this->date_format($from_date)&$this->date_format($to_date)) {} else {
                $from_date = date("Y-m-d") . " 00:00:00";
                $to_date = date("Y-m-d") . " 23:59:59";
                $session->getFlashBag()->add('dmd_flash_error', 'Sai định dạng ngày tháng.');
            }
        }
        
        $orders = $this->getDoctrine()->getRepository('DMDCoffeeBundle:Order')->findByDates($from_date, $to_date);
        $allQuantity = $this->getDoctrine()->getRepository('DMDCoffeeBundle:OrderDetail')->getAllQuantity($from_date, $to_date);
        $inventory_receiving_vochers = $this->getDoctrine()->getRepository('DMDCoffeeBundle:InventoryReceivingVoucher')->findByDates($from_date, $to_date);
        
        return $this->render('DMDCoffeeBundle:Analysis:index.html.twig', 
                array('from_date' => $from_date,
                    'to_date' => $to_date,
                    'orders' => $orders,
                    'all_quantity' => $allQuantity,
                    'inventory_receiving' => $inventory_receiving_vochers,
        ));
    }
    
    public function quantitativeAction(){
        $categories = $this->getDoctrine()->getRepository('DMDCoffeeBundle:Category')->findAll();
        return $this->render('DMDCoffeeBundle:Analysis:quantitative.html.twig', 
                array('categories' => $categories,

        ));
    }
    
    public function updateCostAction(){
        $item_id = $this->getRequest()->get('item_id');
        $item_newcost = $this->getRequest()->get('newcost');
        $item = $this->getDoctrine()->getRepository('DMDCoffeeBundle:Item')->findOneBy(array('id'=>$item_id));
        if($item){
            $item->setCurrentCost($item_newcost);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($item);
            $em->flush();
            return new Response('ok');
        } else {
            return new Response('fail');
        }
    }




    /**
     * Determine if date string is right format "Y-m-d h:i:s"
     * @param string $date
     * @return boolean
     */
    private function date_format($date)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) ([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/",$date))
        {
            return true;
        }else{
            return false;
        }
    }

}
