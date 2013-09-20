<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubtypeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('pointsCount', 'integer')
                ->add('block', 'checkbox', array(
                    'required' => false,
                    'attr' => array('style' => 'margin-left:45%'),
                ))
                ->add('restore', 'checkbox', array(
                    'required' => false,
                    'attr' => array('style' => 'margin-left:45%'),
                ))
                ->add('percent')
                ->add('parameter', 'integer', array('required' => false))
                ->add('typeId', 'hidden')
                ->add('id', 'hidden')
        ;
    }

    public function getName() {
        return '';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

}
