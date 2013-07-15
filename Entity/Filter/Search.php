<?php

namespace Galaxy\BackendBundle\Entity\Filter;

use Doctrine\ORM\Mapping as ORM;

/**
 * Search
 */
class Search
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $messageId;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $theme;

    /**
     * @var string
     */
    private $title;

    /**
     * @var boolean
     */
    private $visible;

    /**
     * @var boolean
     */
    private $moderatorAccepted;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var string
     */
    private $text;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set messageId
     *
     * @param integer $messageId
     * @return Search
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * Get messageId
     *
     * @return integer 
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Search
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return Search
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Search
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Search
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set moderatorAccepted
     *
     * @param boolean $moderatorAccepted
     * @return Search
     */
    public function setModeratorAccepted($moderatorAccepted)
    {
        $this->moderatorAccepted = $moderatorAccepted;

        return $this;
    }

    /**
     * Get moderatorAccepted
     *
     * @return boolean 
     */
    public function getModeratorAccepted()
    {
        return $this->moderatorAccepted;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Search
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Search
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
    
    public function serialize()
    {
        $res = array();
        foreach ($this as $key => $value) {
            $res[$key] = $value;
        }
        return $res;
    }
}
