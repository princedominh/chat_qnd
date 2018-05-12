<?php

namespace DMD\FrontBundle\Admin\Entity;

//use Application\Sonata\AdminBundle\Admin\Admin as Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;

use DMD\FrontBundle\Entity\Subscriber;

/**
 * Description of SubscriberAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class SubscriberAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('email', null, array('label'=>'subscriber.label.email'))
                ->add('is_new', null, array('label'=>'subscriber.label.is_new'))
                ->add('created_at', 'date', array('label'=>'subscriber.label.created_at'))
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
            ->add('email')
            ->add('is_new')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email')
            ->add('is_new')
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
            ->add('email')
            ->add('is_new')
        ;
        $subscriber = $this->getSubject();
        if (get_class($subscriber) == get_class(new Subscriber())) {
            $subscriber->setIsNew(false);
            $this->update($subscriber);
        }
        parent::configureShowFields($filter);
    }

}

