<?php

namespace Galaxy\BackendBundle\Form\Documents;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('title', 'text')
                ->add('pointsTypeName', 'text')
                ->add('period', 'integer', array("required" => false))
                ->add('periodCost', 'integer', array("required" => false))
                ->add('acquisitionExtensionServices', 'textarea', array("required" => false))
                ->add('start', 'integer', array("required" => false))
                ->add('accountHint', 'textarea', array("required" => false))
                ->add('pointsTypeHint', 'textarea', array("required" => false))
                ->add('textPaymentService', 'textarea', array("required" => false))
                ->add('points', 'integer', array("required" => false))
                ->add('cost', 'integer', array("required" => false))
                ->add('notificationZeroBalance', 'textarea', array("required" => false))
        ;
    }

    public function getName()
    {
        return '';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

}