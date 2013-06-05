<?php

namespace Galaxy\BackendBundle\Controller\Documents;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Galaxy\BackendBundle\Form\Documents\RegisterType;

class RegisterController extends Controller
{

    /**
     * @Template()
     */
    public function showAction($id)
    {
        $documentsService = $this->get("documents.remote_service");
        $register = (array)$documentsService->getRegister($id);
        
        $form = $this->createForm( new RegisterType(), $register);
        
        return array(
            "register" => $register,
            "form" => $form->createView(),
        );
    }
    
    /**
     * @Template("GalaxyBackendBundle:Documents/Register:show.html.twig")
     */
    public function updateAction(Request $request, $id){
        $documentsService = $this->get("documents.remote_service");
        $register = (array)$documentsService->getRegister($id);
        $form = $this->createForm( new RegisterType(), $register);
        $form->bindRequest($request);
        
        if($form->isValid()){
            $data = $form->getData();
            $documentsService->updateRegister($id, $data);
        }
        return $this->redirect($this->generateUrl('show_register', array('id' => $id)));
    }

}