<?php
namespace Galaxy\BackendBundle\Entity;
    
class MenuItem
{
    private $title;
    private $href;
    private $url;
    private $child = array();
    private $active;
    private $param = array();
    
    function __construct($title, $href, $url, $param = array())
    {
        $this->title = $title;
        $this->href = $href;
        $this->url = $url;
        $this->param = $param;
    }

    public function getChild()
    {
        return $this->child;
    }

    public function setChild(MenuItem $child)
    {
        $this->child[] = $child;
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
    }

    public function getParam()
    {
        return $this->param;
    }

    public function setParam($param)
    {
        $this->param = $param;
    }

}
