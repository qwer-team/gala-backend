<?php

namespace Galaxy\BackendBundle\Entity;

class MenuItem
{

    private $title;
    private $href;
    private $url;
    private $children = array();
    private $active;
    private $param = array();
    private $parent;

    function __construct($title, $href, $url, $param = array())
    {
        $this->title = $title;
        $this->href = $href;
        $this->url = $url;
        $this->param = $param;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChild(MenuItem $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function setHref($href)
    {
        $this->href = $href;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
        if($this->parent){
            $this->parent->setActive(true);
        }
    }

    public function getParam()
    {
        return $this->param;
    }

    public function setParam($param)
    {
        $this->param = $param;
    }

    public function isVisible()
    {
        return !is_null($this->url) || count($this->children);
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

}
