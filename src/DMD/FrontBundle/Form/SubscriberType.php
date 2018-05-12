<?php

namespace DMD\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Description of SubscriberType
 *
 * @author princedominh <princedominh@gmail.com>
 */
class SubscriberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'label' => 'subscribe.label.email',
            ))
        ;
    }
    
    public function getName() {
        return 'subscribe';
    }
}

