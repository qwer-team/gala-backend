<?php

namespace Galaxy\BackendBundle\Service;

use Galaxy\BackendBundle\Listener\ContainerAware;

class SegmentService extends ContainerAware
{

    public function updateSplitIntoSegment($count)
    {
        $url = $this->container->getParameter("segment.update.url");
        $response = $this->makeRequest($url . $count);
        $result = json_decode($response);
        return $result->result == 'success';
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
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if (!is_null($data)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

}