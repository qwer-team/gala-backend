<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SplitType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', 'integer')
        ;
    }

    public function getName()
    {
        return 'galaxy_BackendBundle_form_space_splitintosegmenttype';
    }

}
