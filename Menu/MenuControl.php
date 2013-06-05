<?php

namespace Galaxy\BackendBundle\Menu;

use Galaxy\BackendBundle\Entity\MenuItem;

class MenuControl
{

    private $menu = array();

    public function addMenu($title, $href, $url = false)
    {
        $this->menu[] = new MenuItem($title, $href, $url);
    }

    public function addChild($title, $href, $url = false, $params = array())
    {
        $menu = $this->menu[count($this->menu) - 1];
        $child = new MenuItem($title, $href, $url, $params);
        $menu->setChild($child);
    }

    public function addGrandchildren($title, $href, $url = false, $param = array())
    {
        $Grandchildren = new MenuItem($title, $href, $url, $param);
        $menu = $this->menu[count($this->menu) - 1];
        $child = $menu->getChild();
        $child = $child[count($child) - 1];
        $child->setChild($Grandchildren);
    }

    public function getAllMenu($route, $params)
    {
        foreach ($this->menu as $menu) {
            if ($menu->getHref() == $route) {
                $menu->setActive('active');
            } elseif ($menu->getChild()) {
                foreach ($menu->getChild() as $child) {
                    if ($child->getHref() == $route) {
                        $active = false;
                        $childParams = $child->getParam();
                        if (count($params) > 0) {
                            foreach ($params as $key => $param) {
                                if (array_key_exists($key, $childParams) &&
                                        $param == $childParams[$key]) {
                                    $active = true;
                                }
                            }
                        } else {
                            $active = true;
                        }
                        if ($active) {
                            $child->setActive('active');
                            $menu->setActive('active');
                            break;
                        }
                    } elseif ($child->getChild()) {
                        foreach ($child->getChild() as $grandchildren) {
                            if ($grandchildren->getHref() == $route) {
                                $active = false;
                                $childParams = $grandchildren->getParam();
                                if (count($params) > 0) {
                                    foreach ($params as $key => $param) {
                                        if (array_key_exists($key, $childParams) &&
                                                $param == $childParams[$key]) {
                                            $active = true;
                                        }
                                    }
                                } else {
                                    $active = true;
                                }
                                if ($active) {
                                    $grandchildren->setActive('active');
                                    $child->setActive('active');
                                    $menu->setActive('active');
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