<?php

namespace DMD\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Description of ContactType
 *
 * @author princedominh <princedominh@gmail.com>
 */
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'label' => 'contact.label.name',
            ))
        ;
        $builder
            ->add('email', 'email', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'label' => 'contact.label.email',
            ))
        ;
        $builder
            ->add('message', 'textarea', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'label' => 'contact.label.message',
                'attr' => array('class' => 'span12', 'rows' => '7'),
            ))
        ;
    }
    
    public function getName() {
        return 'contact';
    }
}

