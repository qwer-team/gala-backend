<?php

namespace Galaxy\BackEndBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SplitIntoSegmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', 'integer', 
                        array('attr' => array('class' => 'span2'))
                 )
        ;
    }

   /* public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\AdminBundle\Entity\Banner\Banner'
        ));
    }*/

    public function getName()
    {
        return 'galaxy_backendbundle_form_space_splitintosegmenttype';
    }
}
