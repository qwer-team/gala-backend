<?php

namespace Galaxy\BackendBundle\Menu;

use Galaxy\BackendBundle\Entity\MenuItem;

class MenuControl
{

    private $menu = array();

    public function addMenu($title, $href, $url = null)
    {
        $this->menu[] = new MenuItem($title, $href, $url);
    }

    public function addChild($title, $href, $url = null, $params = array())
    {
        $menu = end($this->menu);
        $child = new MenuItem($title, $href, $url, $params);
        $menu->setChild($child);
    }

    public function addGrandchildren($title, $href, $url = null, $param = array())
    {
        $Grandchildren = new MenuItem($title, $href, $url, $param);
        $menu = end($this->menu);
        $children = $menu->getChildren();
        $child = end($children);
        $child->setChild($Grandchildren);
    }

    private function checkActive($menu, $params)
    {
        $active = false;
        $childParams = $menu->getParam();
        if (count($params) > 0) {
            foreach ($params as $key => $param) {
                if (array_key_exists($key, $childParams) &&
                        $param == $childParams[$key]) {
                    $active = true;
                } elseif (/*preg_match("/^(\s*|\d+)$/", $param)*/$param == "" && $key == "id") {
                    $active = true;
                }
            }
        } else {
            $active = true;
        }
        if ($active) {
            $menu->setActive('active');
        }

        return $active;
    }

    public function getAllMenu($route, $params)
    {
        foreach ($this->menu as $menu) {
            if ($menu->getHref() == $route) {
                $menu->setActive('active');
            } elseif ($menu->getChildren()) {
                foreach ($menu->getChildren() as $child) {
                    if ($child->getHref() == $route) {
                        if ($this->checkActive($child, $params)) {
                            break;
                        }
                    } elseif ($child->getChildren()) {
                        foreach ($child->getChildren() as $grandchildren) {
                            if ($grandchildren->getHref() == $route) {
                                if ($this->checkActive($child, $params)) {
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this->menu;
    }

}