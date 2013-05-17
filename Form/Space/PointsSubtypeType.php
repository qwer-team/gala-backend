<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PointsSubtypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('id')
            ->add('pointsCount', 'integer')
            ->add('block', 'checkbox')
            ->add('restore', 'checkbox')
            ->add('percent')
         ;
    }

    public function getName()
    {
        return 'galaxy_BackendBundle_form_space_pointssubtypetype';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'stdClass'
        ));
    }
}
