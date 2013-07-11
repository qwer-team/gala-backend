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
        $form = $this->getMessageForm();
        return array(
            "form" => $form->createView(),
        );
    }

    private function getMessageForm($message = null)
    {
        $infoService = $this->get("info.service");
        $form = new MessageType();
        
        $themes = $infoService->getThemesList();
        foreach ($themes as $theme) {
            $themesArr[$theme->id] = $theme->title;
        }
        $form->setThemes($themesArr);
        $data = array("answers" => array(
                array("answer" => ""),
                array("answer" => ""),
                array("answer" => ""),
                array("answer" => ""),
                array("answer" => ""),),
        );
        
        return $this->createForm($form, $message === null ? $data : $message);
    }

    /**
     * @Template("GalaxyBackendBundle:Info/Message:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $infoService = $this->get("info.service");
        $isRoleContent = $this->get('security.context')->isGranted('ROLE_CONTENT');
        $form = $this->getMessageForm();
        $form->bind($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if ($isRoleContent) {
                $data['moderatorAccepted'] = true;
            }
            $storage = $this->get("storage");
            $img = $data['imgfile'];
            if (!is_null($img)) {
                $path = $storage->saveImage($img);
                $data['img'] = $path;
                unset($data['imgfile']);
            }
            $resp = $infoService->createMessage($data);
            $id = $resp->message->id;
            $url = $this->generateUrl('show_message', array('id' => $id));
            return $this->redirect($url);
        } else {
            echo $form->getErrorsAsString();
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
        $message['theme'] = $message['theme']['id'];
        $message['imageDelete'] = false;
        $form = $this->getMessageForm($message);
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
        $isRoleContent = $this->get('security.context')->isGranted('ROLE_CONTENT');
        $form = $this->getMessageForm();
        $form->bindRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if ($isRoleContent) {
                $data['moderatorAccepted'] = true;
            }
            $storage = $this->get("storage");
            $img = $data['imgfile'];
            if (!is_null($img)) {
                $path = $storage->saveImage($img);
                $data['img'] = $path;
                unset($data['imgfile']);
            } else {
                $message = $infoService->getMessage($id);
                $data['img'] = array_key_exists("img",$message) ? $message['img'] : '';
            }
            if($data['imageDelete'] && array_key_exists("img",$message)){
                $storage->deleteImage($message['img']);
                $data['img'] = Null;
                $data['imageDelete'] = false;
            }
            $res = $infoService->updateMessage($id, $data);
            return $this->redirect($this->generateUrl('show_message', array('id' => $id)));
        } else {
            echo $form->getErrorsAsString();
        }
        return array(
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