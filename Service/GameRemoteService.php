<?php

namespace Galaxy\BackendBundle\Service;

use Galaxy\BackendBundle\Listener\ContainerAware;

class GameRemoteService extends ContainerAware
{
    public function getFlipper($id)
    {
        $rawUrl = $this->container->getParameter("games.flipper_show.url");
        $url = str_replace("{id}", $id, $rawUrl);
        $response = json_decode($this->makeRequest($url));
        return $response;
    }
    
    public function updateFlipper($id, $data){
        $rawUrl = $this->container->getParameter("games.flipper_update.url");
        $url = str_replace("{id}", $id, $rawUrl);

        $response = json_decode($this->makeRequest($url, $data));
        return $response;
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