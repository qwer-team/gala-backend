<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('name')
            ->add('message1', 'textarea', array('required' => false, 'label'=> 'Сообщение'))
            ->add('message2', 'textarea', array('required' => false))
            ->add('message3', 'textarea', array('required' => false))
            ->add('onCost', 'checkbox', array('required' => false))
            ->add('cost', 'integer', array('required' => false))
            ->add('onBet', 'checkbox', 
                array('required' => false)
            )
            ->add('bet', 'integer', array('required' => false))
            ->add('betType', 'choice', 
                array(
                    'choices' => array(1 => 'Игровых очков', 2 => 'Спец игровых очков')
                    )
            )
            ->add('bet', 'integer', array('required' => false))
            ->add('onReturn', 'checkbox', array('required' => false))
            ->add('returnValue', 'integer', array('required' => false))
            ->add('returnInPercent', 'checkbox', array('required' => false))
            ->add('onNextStep', 'checkbox', array('required' => false))
            ->add('nextStepValue', 'integer', array('required' => false))
            ->add('nextStepInPercent', 'checkbox', array('required' => false))
            ->add('hours', 'integer', array('required' => false))
            ->add('minutes', 'integer', array('required' => false))
            ->add('tag', 'hidden')
            ->add('id', 'hidden')
         ;
    }

    public function getName()
    {
        return '';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
        ));
    }
}