<?php

namespace Galaxy\BackendBundle\Entity\Filter;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prize
 */
class Prize {

    /**
     * @var integer
     */
    private $id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

}
