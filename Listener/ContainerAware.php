<?php

namespace Galaxy\BackEndBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerAware
                                                        as KernelContainerAware;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
abstract class ContainerAware extends KernelContainerAware
{
    /**
     *
     * @var \Doctrine\ORM\EntityManager 
     */
    protected $em;
    /**
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcher 
     */
    protected $dispatcher;

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {        
        parent::setContainer($container);
        $this->em         = $container->get("doctrine.orm.entity_manager");
        $this->dispatcher = $container->get("event_dispatcher");
    }

}