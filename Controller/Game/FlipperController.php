<?php

namespace Galaxy\BackendBundle\Controller\Game;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Galaxy\BackendBundle\Form\Game\FlipperType;

class FlipperController extends Controller
{
    /**
     * @Template()
     */
    public function showAction($id)
    {
        $gameService = $this->get("game.remote_service");
        $flipper = (array)$gameService->getFlipper($id);
        $form = $this->createForm( new FlipperType(), $flipper);
        
        return array(
            "flipper" => $flipper,
            "form" => $form->createView(),
        );
    }
    
    /**
     * @Template("GalaxyBackendBundle:Game/Flipper:show.html.twig")
     */
    public function updateAction(Request $request, $id){
        $gameService = $this->get("game.remote_service");
        $form = $this->createForm( new FlipperType());
        $form->bindRequest($request);
        if($form->isValid()){
            $data = $form->getData();
            $gameService->updateFlipper($id, $data);
        }
        return $this->redirect($this->generateUrl('flipper_show', array('id' => $id)));
    }
}