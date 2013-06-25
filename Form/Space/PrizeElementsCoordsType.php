<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrizeElementsCoordsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array("attr" => array('class' => "input-mini-mini"));
        $builder
                ->add('a1', 'integer', $attr)
                ->add('a2', 'integer', $attr)
                ->add('a3', 'integer', $attr)
                ->add('b1', 'integer', $attr)
                ->add('b2', 'integer', $attr)
                ->add('b3', 'integer', $attr)
                ->add('c1', 'integer', $attr)
                ->add('c2', 'integer', $attr)
                ->add('c3', 'integer', $attr)
                ->add('delta1', 'integer', $attr)
                ->add('delta2', 'integer', $attr)
                ->add('delta3', 'integer', $attr)
        ;
    }

    public function getName()
    {
        return '';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

}