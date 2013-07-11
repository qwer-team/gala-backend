<?php

namespace Galaxy\BackendBundle\Service;

use Galaxy\BackendBundle\Listener\ContainerAware;
use Qwer\Curl\Curl;

class RemoteService extends ContainerAware
{

    public function updateSplitIntoSegment($count)
    {
        $url = $this->container->getParameter("segment.update.url");
        $response = $this->makeRequest($url . $count);
        $result = json_decode($response);
        return $result->result == 'success';
    }

    public function updatePrizeSplitSegment($count)
    {
        $url = $this->container->getParameter("prize_segment.update.url");
        $response = $this->makeRequest($url . $count);
        $result = json_decode($response);
        return $result->result == 'success';
    }

    public function getPrizeSegments()
    {
        $url = $this->container->getParameter("get.prize_segment.url");
        $points = $this->container->getParameter("points.in.space");
        if (!is_integer($points)) {
            throw new \Exception("You must set valid points number!");
        }
        $response = $this->makeRequest($url);
        $result = json_decode($response);
        for ($i = 0; $i < count($result); $i++) {
            $pers = ($result[$i]->length / $points) * 100;
            $result[$i]->percent = round($pers, 2);
        }
        return $result;
    }

    public function updatePrizeSegmentLength($id, $length)
    {
        $url = $this->container->getParameter("update.prize_segment.length.url");
        $data = array(
            "length" => $length
        );
        $response = $this->makeRequest($url . $id, $data);
        $result = json_decode($response);
        return $result;
    }

    public function getSegments()
    {
        $url = $this->container->getParameter("get.segment.url");
        $points = $this->container->getParameter("points.in.space");
        if (!is_integer($points)) {
            throw new \Exception("You must set valid points number!");
        }
        $response = $this->makeRequest($url);
        $result = json_decode($response);
        for ($i = 0; $i < count($result); $i++) {
            $pers = ($result[$i]->length / $points) * 100;
            $result[$i]->percent = round($pers, 2);
        }
        return $result;
    }

    public function getPointsOnSegment($id)
    {
        $url = $this->container->getParameter("get.points.on.segment.url");
        $response = $this->makeRequest($url . $id);
        $result = json_decode($response);

        for ($i = 0; $i < count($result->subtypes); $i++) {
            $pers = ($result->subtypes[$i]->pointsCount / $result->length) * 100;
            $result->subtypes[$i]->percent = round($pers, 10);
        }

        return $result;
    }

    public function getElementsOnPrizeSegment($id)
    {
        $url = $this->container->getParameter("get.prizes.on.prize_segment.url");
        $response = $this->makeRequest($url . $id);
        $result = json_decode($response);

        foreach ($result->subelements as $subelement)
        {
            $subelement->percent = round($subelement->prizeCount / $result->length * 100, 10); 
        }

        return $result;
    }

    public function saveSubtype($id, $data)
    {
        $url = $this->container->getParameter("create.subtype.url");
        $response = $this->makeRequest($url . $id, $data);
        $result = json_decode($response);
        return $result;
    }

    public function updateSubtype($id, $data)
    {
        $url = $this->container->getParameter("update.subtype.url");
        $response = $this->makeRequest($url . $data["id"], $data);
        $result = json_decode($response);
        return $result;
    }

    public function removeSubtype($id)
    {
        $url = $this->container->getParameter("remove.subtype.url");
        $response = $this->makeRequest($url . $id);
        $result = json_decode($response);
        return $result;
    }
    
    public function saveSubelement($id, $data)
    {
        $url = $this->container->getParameter("create.subelement.url");
        $response = $this->makeRequest($url . $id, $data);
        $result = json_decode($response);
        return $result;
    }

    public function updateSubelement($id, $data)
    {
        $url = $this->container->getParameter("update.subelement.url");
        $response = $this->makeRequest($url . $data["id"], $data);
        $result = json_decode($response);
        return $result;
    }

    public function removeSubelement($id)
    {
        $url = $this->container->getParameter("remove.subelement.url");
        $response = $this->makeRequest($url . $id);
        $result = json_decode($response);
        return $result;
    }

    public function updateSegmentLength($id, $length)
    {
        $url = $this->container->getParameter("update.segment.length.url");
        $data = array(
            "length" => $length
        );
        $response = $this->makeRequest($url . $id, $data);
        $result = json_decode($response);
        return $result;
    }

    private function makeRequest($url, $data = null)
    {
        return Curl::makeRequest($url, $data);
    }

    public function getType($tag)
    {
        $url = $this->container->getParameter("get.type.url");
        $response = $this->makeRequest($url . $tag);
        $result = (array) json_decode($response);
        return $result;
    }

    public function updateType($data)
    {
        $url = $this->container->getParameter("update.type.url");
        $response = $this->makeRequest($url, $data);
        $result = json_decode($response);
        return $result;
    }

    public function getTypeList()
    {
        $url = $this->container->getParameter("get.type_list.url");
        $response = $this->makeRequest($url);
        $result = json_decode($response);
        return $result;
    }

    public function updateCoords($data)
    {
        $url = $this->container->getParameter("get.type_update_coords.url");
        $response = $this->makeRequest($url, $data);
        $result = json_decode($response);
        return $result;
    }

    public function getPrizesList()
    {
        $url = $this->container->getParameter("get.prize_list.url");
        $response = $this->makeRequest($url);
        $result = json_decode($response, true);
        return $result;
    }

    public function updatePrize($id, $data)
    {
        $url = $this->container->getParameter("get.prize_update.url");
        $response = $this->makeRequest($url . $id, $data);
        $result = json_decode($response, true);
        return $result;
    }

    public function addPrize($data)
    {
        $url = $this->container->getParameter("get.prize_add.url");
        $response = $this->makeRequest($url, $data);
        $result = json_decode($response);
        return $result->id;
    }

    public function getPrizeElement($id)
    {
        $url = $this->container->getParameter("get.element_get.url");
        $response = $this->makeRequest($url . $id);
        $result = json_decode($response, true);
        return $result;
    }

    public function updatePrizeElement($id, $data)
    {
        $url = $this->container->getParameter("get.element_update.url");
        $response = $this->makeRequest($url . $id, $data);
        $result = json_decode($response, true);
        return $result;
    }

    public function addPrizeElement($prizeId, $data)
    {
        $url = $this->container->getParameter("get.element_add.url");
        $response = $this->makeRequest($url . $prizeId, $data);
        $result = json_decode($response);
        return $result->id;
    }

    public function deletePrizeElement($id)
    {
        $url = $this->container->getParameter("get.element_delete.url");
        $response = $this->makeRequest($url . $id);
        $result = json_decode($response);
        return $result;
    }

    public function deletePrize($id)
    {
        $url = $this->container->getParameter("get.prize_delete.url");
        $response = $this->makeRequest($url . $id);
        $result = json_decode($response);
        return $result;
    }

    public function getSubelementsSingleList()
    {
        $url = $this->container->getParameter("get.subelement_single_list.url");
        $response = $this->makeRequest($url);
        $result = json_decode($response);
        return $result;
    }

    public function loadUpdatePrize($id, $data)
    {
        $url = $this->container->getParameter("get.update_single_subelement.url");
        $response = $this->makeRequest($url . $id, $data);
        $result = json_decode($response);
        return $result;
    }

    public function loadAddPrize($data)
    {
        $url = $this->container->getParameter("get.add_single_subelement.url");
        $response = $this->makeRequest($url, $data);
        $result = json_decode($response);
        return $result;
    }
    
    public function updateElementCoords ($id, $data)
    {
        $url = $this->container->getParameter("get.element_update_coords.url");
        $response = $this->makeRequest($url . $id, $data);
        $result = json_decode($response);
        return $result;
    }

}