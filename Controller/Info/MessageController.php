<?php

namespace Galaxy\BackendBundle\Controller\Info;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Galaxy\BackendBundle\Form\Info\MessageType;

/**
 * Description of MessageController
 *
 * @author root
 */
class MessageController extends Controller
{
    
    /**
     * @Template()
     */
    public function messageAction($page, $length)
    {
        $messageService = $this->get("info.service");
        $messages = $messageService->getMessagesList($page, $length);
        $count = $messageService->getMessagesCount();
        $pagesCount = ceil($count / $length);
        
        return array(
              "messages" => $messages,
              'count' => $count,
              'pagesCnt' => $pagesCount,
              'page' => $page,
              'length' => $length,
        );
    }
    
    /**
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new MessageType());
        return array(
            "form" => $form->createView(),
        );
    }
    
    /**
     * @Template("GalaxyBackendBundle:Info/Message:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $infoService = $this->get("info.service");
        $form = $this->createForm(new MessageType());
        $form->bindRequest($request);
        
        if ($form->isValid()) {
            $data = $form->getData();
            $resp = $infoService->createMessage($data);
            $id = $resp->message->id ;
            $url = $this->generateUrl('show_message', array('id' => $id));
            return $this->redirect($url);
        }
        return array(
            "form" => $form->createView(),
        );
    }

    /**
     * @Template()
     */
    public function showAction($id)
    {
        $infoService = $this->get("info.service");
        $message = (array) $infoService->getMessage($id);
        $form = $this->createForm(new MessageType(), $message);
        return array(
            "message" => $message,
            "form" => $form->createView(),
        );
    }

    /**
     * @Template("GalaxyBackendBundle:Info/Message:show.html.twig")
     */
    public function updateAction($id, Request $request)
    {
        $infoService = $this->get("info.service");
        $form = $this->createForm(new MessageType());
        $form->bindRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $infoService->updateMessage($id, $data);
            return $this->redirect($this->generateUrl('show_message', array('id' => $id)));
        }
        return array(
            "message" => $message,
            "form" => $form->createView(),
        );
    }
    
    
    public function deleteAction($id)
    {
        $infoService = $this->get("info.service");
        $infoService->deleteMessage($id);
        return $this->redirect($this->generateUrl('messages_list'));
    }

}