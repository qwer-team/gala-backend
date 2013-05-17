<?php
namespace Galaxy\BackendBundle\Menu;
use Galaxy\BackendBundle\Entity\MenuItem;

class MenuControl
{
    private $menu=array();   
    
    public function addMenu($title, $href, $url = false)
    {
        $this->menu[]= new MenuItem($title, $href, $url);
        
    }
    
    public function addChild($title, $href, $url = false)
    {
       $menu = $this->menu[count($this->menu)-1];
       $child = new MenuItem($title, $href, $url);
       $menu->setChild($child);
    }
    
    public function addGrandchildren($title, $href, $url = false)
    {
        $Grandchildren = new MenuItem($title, $href, $url);
        $menu = $this->menu[count($this->menu)-1];
        $child = $menu->getChild();
        $child = $child[count($child)-1];
        $child->setChild($Grandchildren);
    }
    public function getAllMenu($route)
    {
        foreach ($this->menu as $menu) {
            if($menu->getHref() == $route)
            {
                $menu->setActive('active');
            }
            elseif ($menu->getChild()) {
                foreach ($menu->getChild() as $child) {
                    if($child->getHref() == $route)
                    {
                        $child->setActive('active');
                        $menu->setActive('active');
                    }
                    elseif ($child->getChild()) {
                        foreach ($child->getChild() as $grandchildren) {
                            if($grandchildren->getHref() == $route)
                            {
                                $grandchildren->setActive('active');
                                $child->setActive('active');
                                $menu->setActive('active');
                            }
                        }
                    }
                }
            }
        }
        return $this->menu;
    }
}

?>
