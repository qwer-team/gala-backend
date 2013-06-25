<?php

namespace Galaxy\BackendBundle\Controller\Documents;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Galaxy\BackendBundle\Form\Documents\DocumentType;

class DocumentController extends Controller
{

    /**
     * @Template()
     */
    public function listAction($type, $page, $length)
    {
        $documentsService = $this->get("documents.remote_service");
        $documents = $documentsService->getDocuments($type, $page, $length);
        $count = $documentsService->getDocumentsCount($type);
        $pagesCount = ceil($count / $length);


        return array(
            'documents' => $documents,
            'count' => $count,
            'pagesCnt' => $pagesCount,
            'page' => $page,
            'type' => $type,
            'length' => $length,
        );
    }

    /**
     * @Template()
     */
    public function newAction($type)
    {
        $form = $this->createForm(new DocumentType());
        return array(
            "type" => $type,
            "form" => $form->createView(),
        );
    }

    /**
     * @Template("GalaxyBackendBundle:Documents/Document:new.html.twig")
     */
    public function createAction($type, Request $request)
    {
        $documentsService = $this->get("documents.remote_service");
        $form = $this->createForm(new DocumentType());
        $form->bindRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $resp = $documentsService->createDocument($type, $data);
            $id = $resp->document->id ;
            $url = $this->generateUrl('show_document', array('id' => $id));
            return $this->redirect($url);
        }
        return array(
            "type" => $type,
            "form" => $form->createView(),
        );
    }

    /**
     * @Template()
     */
    public function showAction($id)
    {
        $documentsService = $this->get("documents.remote_service");
        $document = (array) $documentsService->getDocument($id);
        $disabled = array();
        if($document["status"] == 2){
            $disabled = array('disabled' => true);
        }
        $form = $this->createForm(new DocumentType(), $document, $disabled);
        return array(
            "document" => $document,
            "form" => $form->createView(),
        );
    }

    /**
     * @Template("GalaxyBackendBundle:Documents/Document:show.html.twig")
     */
    public function updateAction($id, Request $request)
    {
        $documentsService = $this->get("documents.remote_service");
        $document = (array) $documentsService->getDocument($id);
        $form = $this->createForm(new DocumentType(), $document);
        $form->bindRequest($request);
        
        if ($form->isValid() && $document['status'] == 1) {
            $data = $form->getData();
            $documentsService->updateDocument($id, $data);
            return $this->redirect($this->generateUrl('show_document', array('id' => $id)));
        }
        return array(
            "document" => $document,
            "form" => $form->createView(),
        );
    }
    
    public function approveAction($id)
    {
        $documentsService = $this->get("documents.remote_service");
        $result = $documentsService->approveDocument($id);
        
        $url = $this->generateUrl('show_document', array('id' => $id));
        return $this->redirect($url);
    }
    
    public function returnAction($id)
    {
        $documentsService = $this->get("documents.remote_service");
        $result = $documentsService->returnDocument($id);
        
        $url = $this->generateUrl('show_document', array('id' => $id));
        return $this->redirect($url);
    }

}