<?php

namespace Galaxy\BackendBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class StorageService
{

    private $folder;
    private $relUrl;

    public function save(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();
        $file->move($this->folder, $fileName);
        $path = $this->relUrl . $fileName;
        return $path;
    }

    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    public function setRelUrl($relUrl)
    {
        $this->relUrl = $relUrl;
    }

}