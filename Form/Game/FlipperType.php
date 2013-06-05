<?php

namespace Galaxy\BackendBundle\Form\Game;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FlipperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array("required" => false))
            ->add('maxJump', 'integer', array("required" => false))
            ->add('costJump', 'integer', array("required" => false))
            ->add('impossibleJumpHint', 'textarea', array("required" => false))
            ->add('paymentFromDeposit', 'checkbox', array(
                "required" => false,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return '';
    }
}
