<?php

namespace DMD\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use DMD\FrontBundle\Entity\Contact;
use DMD\FrontBundle\Entity\Subscriber;
use DMD\FrontBundle\Form\ContactType;
use DMD\FrontBundle\Form\SubscriberType;
use DMD\FrontBundle\Form\SearchType;

class DefaultController extends Controller {

    public function indexAction() {
        
        return $this->render('DMDFrontBundle:Default:index.html.twig', array(
        ));
    }

    public function productsAction() {
        return $this->render('DMDFrontBundle:Default:products.html.twig');
    }

      public function checkoutAction() {
    $session = new Session();
     $request = $this->getRequest();
    $session = $this->get('session');
    $session->start();
    $session->set('cart','0');
    if ($request) {
        $value = $session->get('cart');
        $session->set('cart',$value);
    }
    return $this->render("DMDFrontBundle:Default:checkout.html.twig", array(
        ));
    
    }


    public function contactAction() {
        $request = $this->getRequest();
        $session = $this->get('session');
        $contact = new Contact();

        $form = $this->createForm(new ContactType(), $contact);

        if ($request->isMethod('POST')) {
            try {
                $form->bindRequest($request);
                $em = $this->getDoctrine()->getManager();

                //get ip of user
                $ip = $request->getClientIp();
                $contact->setIpAddress($ip);

                //save Contact message
                $em->persist($contact);
                $em->flush();

                //set session flashbag
                $session->getFlashBag()->add('dmd_flash_success', 'contact.message.success');

                //mail to admin
                $this->sendEmail($contact);

                return $this->redirect($this->generateUrl('dmd_front_contact'));
            } catch (\Exception $e) {
                $session->getFlashBag()->add('dmd_flash_error', 'contact.message.error');
            }
        }
        return $this->render('DMDFrontBundle:Default:contact.html.twig', array(
                    'form' => $form->createView(),
                ));
    }
    
    public function subscribeAction()
    {
        $request = $this->getRequest();
        $session = $this->get('session');
        $subscriber = new Subscriber();

        $form = $this->createForm(new SubscriberType(), $subscriber);

        if ($request->isMethod('POST')) {
            try {
                $form->bindRequest($request);
                $em = $this->getDoctrine()->getManager();

                //save Subscriber message
                $em->persist($subscriber);
                $em->flush();

                //set session flashbag
                $session->getFlashBag()->add('dmd_flash_success', 'subscribe.message.success');

                //mail to admin
                $this->sendSubscriberEmail($subscriber);

                return $this->redirect($request->getRequestUri());
            } catch (\Exception $e) {
                $session->getFlashBag()->add('dmd_flash_error', 'subscribe.message.error');
            }
        }

        return $this->redirect($this->generateUrl('_welcome'));
    }
    
    public function subscribeFormAction()
    {
        $form = $this->createForm(new SubscriberType());
        
        return $this->render('DMDFrontBundle:Default:subscribe_form.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    public function searchFormAction(Request $request)
    {
        $session = $this->get('session');
        $form = $this->createForm(new SearchType());
        try {
            $data = $request->query->get('search');
            if (!empty($data['key'])) {
                $form->setData(array('key'=>$data['key']));
            }
        } catch (\Exception $e) {
            $session->getFlashBag()->add('dmd_flash_error', 'search form error');
        }
        
        return $this->render('DMDFrontBundle:Default:search_form.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    private function sendEmail(Contact $contact) {
        $message = \Swift_Message::newInstance()
                ->setSubject('[KOHI-Contact] New contact message')
                ->setFrom($contact->getEmail())
                ->setTo($this->container->getParameter('contact_email'))
                ->setBody($this->renderView(
                        'DMDFrontBundle:Mail:email.contact.twig', array(
                            'username' => "KOHI Master",
                            'contact' => $contact,
                        )
                ))
                ->setContentType("text/html")
        ;
        $this->get('mailer')->send($message);
    }
    
    private function sendSubscriberEmail(Subscriber $subscriber) 
    {
        $message = \Swift_Message::newInstance()
                ->setSubject('[KOHI-Subscriber] New contact message')
                ->setFrom($this->container->getParameter('contact_email'))
                ->setTo($subscriber->getEmail())
                ->setBody($this->renderView(
                        'DMDFrontBundle:Mail:email.subscriber.twig', array(
                            'username' => $subscriber->getEmail(),
                            'subscriber' => $subscriber,
                        )
                ))
                ->setContentType("text/html")
        ;
        $this->get('mailer')->send($message);
    }
    
private function headerAction (){
    
}
   
}
