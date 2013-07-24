<?php

namespace Galaxy\BackendBundle\Controller\Info;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Galaxy\BackendBundle\Form\Info\MessageType;
use Galaxy\BackendBundle\Entity\Filter\Search;
use Galaxy\BackendBundle\Form\Filter\SearchType;

class MessageController extends Controller
{

    /**
     * @Template()
     */
    public function messageAction($page, $length)
    {
        $messageService = $this->get("info.service");
        $themes = $messageService->getThemesList();
        $search = $this->getSearch();
        foreach ($themes as $theme) {
            $themesArr[$theme->id] = $theme->title;
        }
        $searchForm = new SearchType();
        $searchForm->setThemes($themesArr);
        $form = $this->createForm($searchForm, $search);
        $data = $search->serialize();
        $messages = (array)$messageService->getMessagesList($page, $length, $data);
        $count = $messageService->getMessagesCount($data);
        $pagesCount = ceil($count / $length);

        return array(
            "form" => $form->createView(),
            "messages" => $messages,
            'count' => $count,
            'pagesCnt' => $pagesCount,
            'page' => $page,
            'length' => $length,
        );
    }

    public function updateSearchAction(Request $request)
    {
        $messageService = $this->get("info.service");
        $themes = $messageService->getThemesList();
        $search = $this->getSearch();
        foreach ($themes as $theme) {
            $themesArr[$theme->id] = $theme->title;
        }
        $searchForm = new SearchType();
        $searchForm->setThemes($themesArr);
        $form = $this->createForm($searchForm, $search);
        $form->bind($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $request->getSession()->set('search', $data);
        }

        return $this->redirect($this->generateUrl('messages_list'));
    }

    private function getSearch()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->has("search")) {
            $search = new Search();
            $session->set("search", $search);
        } else {
            $search = $session->get("search");
        }
        return $search;
    }

    

    /**
     * @Template()
     */
    public function newAction()
    {
        $infoService = $this->get("info.service");
        $template = (array) $infoService->getTemplate();
        $form = $this->getMessageForm(null, $template);
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
        $isRoleContent = $this->get('security.context')->isGranted('ROLE_CONTENT');
        $form = $this->getMessageForm();
        $form->bind($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if ($isRoleContent) {
                $data['moderatorAccepted'] = true;
            }
            $postData = $this->dataImageProcessing($data);
            $resp = $infoService->createMessage($postData);
            $infoService->updateTemplate($postData);
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
        $message = $infoService->getMessage($id);
        $message['theme'] = array_key_exists("theme", $message) ? $message['theme']['id'] : '' ;
        $message['imageDelete'] = false;
        $form = $this->getMessageForm($message);
        return array(
            "message" => $message,
            "form" => $form->createView(),
        );
    }
    
    /**
     * @Template()
     */
    public function previewAction($id)
    {
        $infoService = $this->get("info.service");
        $message = $infoService->getMessage($id);
        return array(
            "message" => $message,
            
        );
    }

    /**
     * @Template("GalaxyBackendBundle:Info/Message:show.html.twig")
     */
    public function updateAction($id, Request $request)
    {
        $infoService = $this->get("info.service");
        $gameService = $this->get("game.remote_service");
        $message = $infoService->getMessage($id);
        $messageLastId = $infoService->getMessageLastId();
        $form = $this->getMessageForm();
        $form->bindRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if ($data['moderatorAccepted'] == true && $message["moderatorAccepted"] != true) {
                $gameService->increaseUserCountMessages($data['userId']);
            } elseif ($message["moderatorAccepted"] == true) {
                $data['moderatorAccepted'] = true;
            }
            $postData = $this->dataImageProcessing($data, $id);
            $infoService->updateMessage($id, $postData);
            if ($messageLastId == $id) {
                $infoService->updateTemplate($postData);
            }
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

    private function dataImageProcessing($data, $id = null)
    {
        $infoService = $this->get("info.service");
        $storage = $this->get("storage");
        $img = $data['imgfile'];
        $message = $infoService->getMessage($id);
        if (!is_null($img)) {
            $path = $storage->saveImage($img);
            $data['img'] = $path;
            unset($data['imgfile']);
        } elseif ($data['imageDelete'] && array_key_exists("img", $message)) {
            $storage->deleteImage($message['img']);
            $data['img'] = Null;
            $data['imageDelete'] = false;
        } elseif ($id !== null) {
            $data['img'] = array_key_exists("img", $message) ? $message['img'] : '';
        }
        return $data;
    }

    private function getMessageForm($message = null, $template = array())
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
        $data += $template;

        return $this->createForm($form, $message === null ? $data : $message);
    }

}