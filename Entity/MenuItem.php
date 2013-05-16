<?php
namespace Galaxy\BackEndBundle\Entity;
    
class MenuItem
{
    private $title;
    private $href;
    private $url;
    private $child = array();
    private $active;
    
    function __construct($title, $href, $url)
    {
        $this->title = $title;
        $this->href = $href;
        $this->url = $url;
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

}

?>
