<?php

namespace Galaxy\BackEndBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubtypeGroupType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name',null, array('disabled' => 'disabled'))
                ->add('subtypes', 'collection', array('type' => new PointsSubtypeType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,)
        );
    }

    public function getName()
    {
        return 'galaxy_backendbundle_form_space_subtypegrouptype';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'stdClass'
        ));
    }

}
