<?php

namespace DMD\FrontBundle\Admin\Entity;

//use Application\Sonata\AdminBundle\Admin\Admin as Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;

use DMD\FrontBundle\Entity\Contact;

/**
 * Description of ContactAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class ContactAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name', null, array('label'=>'contact.label.name'))
                ->add('email', null, array('label'=>'contact.label.email'))
                ->add('message', null , array(
                    'label'=>'contact.label.message',
                    'template'=>'ApplicationSonataAdminBundle:Admin:list_message.html.twig',
                    ))
                ->add('is_read', null, array('label'=>'contact.label.is_read'))
                ->add('is_star', null, array('label'=>'contact.label.is_star'))
                ->add('ip_address', null, array('label'=>'contact.label.ip_address'))
                ->add('_action', 'actions', array(
                        'actions' => array(
                        'view' => array(),
                        'delete' => array(),
                        )));
        parent::configureListFields($listMapper);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('email')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('email')
            ->add('message')
            ->add('is_read', null, array('required'=>false,))
            ->add('is_star', null, array('required'=>false,))
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
                ->add('name')
                ->add('email')
                ->add('message')
                ->add('is_read')
                ->add('is_star')
                ->add('ip_address')
        ;
        $contact = $this->getSubject();
        if (get_class($contact) == get_class(new Contact())) {
            $contact->setIsRead(true);
            $this->update($contact);
        }
        parent::configureShowFields($filter);
    }

}

