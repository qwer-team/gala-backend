<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('flipper', 'integer')
            ->add('sms', 'text')
            ->add('message1', 'textarea', array("required" => false))
            ->add('message2', 'textarea', array("required" => false))
            ->add('penalty', 'integer')
            ->add('imgfile1', 'file', array("required" => false))
            ->add('imgfile2', 'file', array("required" => false))
        ;
    }
    
    public function getName()
    {
        return '';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => true,
        ));
    }
}