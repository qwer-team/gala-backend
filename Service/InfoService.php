<?php

namespace Galaxy\BackendBundle\Service;


class InfoService
{
    private $messagesListUrl;
    private $messagesCountUrl;
    private $messageCreateUrl;
    private $messageUpdateUrl;
    private $messageGetUrl;
    private $messageDeleteUrl;
    
    public function setMessagesListUrl($messagesListUrl)
    {
        $this->messagesListUrl = $messagesListUrl;
    }

    public function setMessagesCountUrl($messagesCountUrl)
    {
        $this->messagesCountUrl = $messagesCountUrl;
    }

    public function setMessageCreateUrl($messageCreateUrl)
    {
        $this->messageCreateUrl = $messageCreateUrl;
    }

    public function setMessageUpdateUrl($messageUpdateUrl)
    {
        $this->messageUpdateUrl = $messageUpdateUrl;
    }

    public function setMessageGetUrl($messageGetUrl)
    {
        $this->messageGetUrl = $messageGetUrl;
    }

    public function setMessageDeleteUrl($messageDeleteUrl)
    {
        $this->messageDeleteUrl = $messageDeleteUrl;
    }

            
    public function getMessagesList($page, $length)
    {
        $find = array("{page}", "{length}");
        $replace = array($page, $length);

        $url = str_replace($find, $replace, $this->messagesListUrl);
        $response = json_decode($this->makeRequest($url));
        return $response;
    }
    
    public function getMessagesCount()
    {
        $response = json_decode($this->makeRequest($this->messagesCountUrl));
        return $response;
    }
    
    public function getMessage($id){
        $url = str_replace("{id}", $id, $this->messageGetUrl);

        $response = json_decode($this->makeRequest($url), true);
        return $response;
    }

    public function deleteMessage($id){
        $url = str_replace("{id}", $id, $this->messageDeleteUrl);

        $response = json_decode($this->makeRequest($url));
        return $response;
    }
    
    public function createMessage($data){
        $response = json_decode($this->makeRequest($this->messageCreateUrl, $data));
        return $response;
    }
    
    public function updateMessage($id, $data)
    {
        $url = str_replace("{id}", $id, $this->messageUpdateUrl);
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
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

}