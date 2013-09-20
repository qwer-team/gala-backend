<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrizeSubelementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  
            ->add('prizeCount', 'text', array(
                'attr' => array('class' => 'span2'),
            ))
            ->add('percent', 'text', array(
                'attr' => array('class' => 'span2'),
            ))
            ->add('restore', 'checkbox', array(
                'required' => false,
                'attr' => array('style' => 'width:30px;margin-left:30px'),
                )) 
            ->add('elementId', 'hidden')
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