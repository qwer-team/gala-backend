<?php

namespace Galaxy\BackendBundle\Controller\Space;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Galaxy\BackendBundle\Form\Space\SplitType;
use Galaxy\BackendBundle\Form\Space\SegmentType;
use Symfony\Component\HttpFoundation\Response;
use Galaxy\BackendBundle\Form\Space\SubtypeGroupType;
use Galaxy\BackendBundle\Form\Space\SubtypeType;
use Galaxy\BackendBundle\Form\Space\TypeForm;
use Galaxy\BackendBundle\Form\Space\TypeCoordType;

class BootstrapController extends Controller
{

    /**
     * @Template()
     * @return type
     */
    public function segmentsAction()
    {
        $type = new SplitType();
        $segmentService = $this->container->get('remote.service');
        $allSegments = $segmentService->getSegments();
        $countSegments = count($allSegments);
        $form = $this->createForm($type);
        $form->setData(
                array('count'=> $countSegments)
                );
        return array(
            'splitIntoSegmentForm' => $form->createView(),
        );
    }
    
    
    /**
     * @Template()
     * @return type
     */
    public function prizeSegmentsAction()
    {
        $type = new SplitType();
        $segmentService = $this->container->get('remote.service');
        $allSegments = $segmentService->getPrizeSegments();
        $countSegments = count($allSegments);
        $form = $this->createForm($type);
        $form->setData(
                array('count'=> $countSegments)
                );
        return array(
            'splitIntoSegmentForm' => $form->createView(),
        );
    }
    
    
    /**
     * @Template("GalaxyBackendBundle:Space\Bootstrap:prizeSegments.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function splitPrizeAction(Request $request)
    {
        $form = $this->createForm(new SplitType());
        $form->bind($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $count = $data["count"];
            $segment = $this->container->get('remote.service');

            if ($segment->updatePrizeSplitSegment($count)) {
                return $this->redirect($this->generateUrl('show_prize_segments'));
            }
        }
        return array(
            'splitIntoSegmentForm' => $form->createView(),
        );
    }
    
    /**
     * @Template()
     * @return type
     */
    public function showPrizeSegmentsAction()
    {
        $segment = $this->container->get('remote.service');
        $allSegments = $segment->getPrizeSegments();

        $segmentsForm = array();

        foreach ($allSegments as $oneSegment) {
            $segmentsForm[$oneSegment->id] = $this->createForm(new SegmentType(), $oneSegment)
            ->createView();
        }

        return array(
            'segments_form' => $segmentsForm,
            'allSegments' => $allSegments,
            );
    }
    
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updatePrizeSegmentLengthAction(Request $request, $id)
    {
        $segment = $this->container->get('remote.service');
        $form = $this->createForm(new SegmentType());
        $form->bind($request);
        $json = array();
        if ($form->isValid()) {
            $data = $form->getData();

            $length = $data["length"];
            //$percent = $data["percent"];
            $json = $segment->updatePrizeSegmentLength($id, $length);
        } 
        $json->id = $id;
        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }

    /**
     * @Template("GalaxyBackendBundle:Space\Bootstrap:segments.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function splitAction(Request $request)
    {
        $form = $this->createForm(new SplitType());
        $form->bind($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $count = $data["count"];
            $segment = $this->container->get('remote.service');

            if ($segment->updateSplitIntoSegment($count)) {
                return $this->redirect($this->generateUrl('show_segments'));
            }
        }
        return array(
            'splitIntoSegmentForm' => $form->createView(),
        );
    }

    /**
     * @Template()
     * @return type
     */
    public function showSegmentsAction()
    {
        $segment = $this->container->get('remote.service');
        $allSegments = $segment->getSegments();

        $segmentsForm = array();

        foreach ($allSegments as $oneSegment) {
            $segmentsForm[$oneSegment->id] = $this->createForm(new SegmentType(), $oneSegment)
            ->createView();
        }

        return array(
            'segments_form' => $segmentsForm,
            'allSegments' => $allSegments);
    }

    /**
     * @Template()
     * @param type $id
     * @return type
     */
    public function segmentConfigAction($id)
    {
        $segmentService = $this->container->get('remote.service');
        $entity = $segmentService->getPointsOnSegment($id);
        $segmentLength = $entity->length;
        $types = array();
        $count= 0;
        
        foreach ($entity->types as $type) {
            $type->subtypes = array();
            $new = array("typeId" => $type->id);
            $type->form = array($this->createForm(new SubtypeType(), $new)->createView());
            $types[$type->id] = $type;
        }

        foreach ($entity->subtypes as $subtypes) {
            $typeId = $subtypes->typeId;
            $form = $this->createForm(new SubtypeType(), $subtypes)->createView();
            $types[$typeId]->subtypes[] = $form;
            $count += $subtypes->pointsCount;
        }
        

        return array(
            'id' => $id,
            'types' => $types,
            'count' => $count,
            'segmentLength' => $segmentLength,
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveSubtypeAction(Request $request, $id)
    {
        return $this->saveSubtype($request, $id, "saveSubtype");
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSubtypeAction(Request $request, $id)
    {
        return $this->saveSubtype($request, $id, "updateSubtype");
    }

    private function saveSubtype(Request $request, $id, $method)
    {
        $segment = $this->container->get('remote.service');
        $form = $this->createForm(new SubtypeType(), array());
        $form->bind($request);
        $json = array();
        if ($form->isValid()) {
            $data = $form->getData();
            $json = $segment->$method($id, $data);
        }
        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }

    public function removeSubtypeAction($id)
    {
        $segment = $this->container->get('remote.service');
        
        $json = $segment->removeSubtype($id);
        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSegmentLengthAction(Request $request, $id)
    {
        $segment = $this->container->get('remote.service');
        $form = $this->createForm(new SegmentType());
        $form->bind($request);
        $json = array();
        if ($form->isValid()) {
            $data = $form->getData();

            $length = $data["length"];
            //$percent = $data["percent"];
            $json = $segment->updateSegmentLength($id, $length);
        } 
        $json->id = $id;
        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
    
    /**
     * @Template()
     * @return type
     */
    public function loadingAction(){
        $segment = $this->container->get('remote.service');
        $allSegments = $segment->getSegments();
        
        return array('segments' => $allSegments);
    }
    
    /**
     * @Template()
     */
    public function typeConfigAction($tag, Request $request){
        $typeService = $this->container->get('remote.service');
        $type = $typeService->getType($tag);
        $form = $this->createForm(new TypeForm(), $type);
        if($request->getMethod() == 'POST'){
            $form->bindRequest($request);
            if($form->isValid()){
                $data = $form->getData();
                $typeService->updateType($data);
            }
        }
        return array(
            'tag' => $tag,
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Template()
     */
    public function changeCoordsAction(){
        $typeService = $this->container->get('remote.service');
        $rawTypes = $typeService->getTypeList();
        $types = array();
        foreach($rawTypes as $type){
            $typeArr = array();
            $form = $this->createForm(new TypeCoordType(),(array)$type);
            
            $typeArr["type"] = $type;
            $typeArr["form"] = $form->createView();
            $types[] = $typeArr;
        }
        
        
        return array( "types" => $types);
    }
    
    public function updateCoordsAction(Request $request){
        $form = $this->createForm(new TypeCoordType());
        $form->bindRequest($request);
        
        $result = json_encode(array("result" => "fail"));
        if($form->isValid()){
            $data = $form->getData();
            $typeService = $this->container->get('remote.service');
            $result = $typeService->updateCoords($data);
        }
        
        $response = new Response();
        $response->setContent(json_encode($result));

        return $response;
    }

}
