<?php

namespace Galaxy\BackendBundle\Service;

use Galaxy\BackendBundle\Listener\ContainerAware;

class DocumentsRemoteService extends ContainerAware
{

    public function getRegister($id)
    {
        $rawUrl = $this->container->getParameter("documents.show_register.url");
        $url = str_replace("{id}", $id, $rawUrl);

        $response = json_decode($this->makeRequest($url));
        return $response;
    }

    public function updateRegister($id, $data)
    {
        $rawUrl = $this->container->getParameter("documents.update_register.url");
        $url = str_replace("{id}", $id, $rawUrl);

        $response = json_decode($this->makeRequest($url, $data));
        return $response;
    }

    public function getDocuments($type, $page, $length)
    {
        $rawUrl = $this->container->getParameter("documents.document_list.url");

        $find = array("{page}", "{length}", "{type}");
        $replace = array($page, $length, $type);

        $url = str_replace($find, $replace, $rawUrl);
        $response = json_decode($this->makeRequest($url));
        return $response;
    }
    
    public function getDocument($id){
        $rawUrl = $this->container->getParameter("documents.document_show.url");
        $url = str_replace("{id}", $id, $rawUrl);

        $response = json_decode($this->makeRequest($url));
        return $response;
    }

    public function getDocumentsCount($type)
    {
        $rawUrl = $this->container->getParameter("documents.document_count.url");
        $find = array("{type}");
        $replace = array( $type);
        $url = str_replace($find, $replace, $rawUrl);
        
        $response = json_decode($this->makeRequest($url));
        return $response->count;
    }
    
    public function createDocument($type, $data){
        $rawUrl = $this->container->getParameter("documents.document_create.url");
        $url = str_replace("{type}", $type, $rawUrl);

        $response = json_decode($this->makeRequest($url, $data));
        return $response;
    }
    
    public function updateDocument($id, $data)
    {
        $rawUrl = $this->container->getParameter("documents.document_update.url");
        $url = str_replace("{id}", $id, $rawUrl);
        
        $response = json_decode($this->makeRequest($url, $data));
        return $response;
    }
    
    public function approveDocument($id){
        $rawUrl = $this->container->getParameter("documents.document_approve.url");
        $url = str_replace("{id}", $id, $rawUrl);

        $response = json_decode($this->makeRequest($url));
        return $response;
    }
    
    public function returnDocument($id){
        $rawUrl = $this->container->getParameter("documents.document_return.url");
        $url = str_replace("{id}", $id, $rawUrl);

        $response = json_decode($this->makeRequest($url));
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