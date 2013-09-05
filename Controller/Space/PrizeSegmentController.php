<?php

namespace Galaxy\BackendBundle\Controller\Space;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Galaxy\BackendBundle\Form\Space\SplitType;
use Galaxy\BackendBundle\Form\Space\SegmentType;
use Symfony\Component\HttpFoundation\Response;
use Galaxy\BackendBundle\Form\Space\SubtypeGroupType;
use Galaxy\BackendBundle\Form\Space\PrizeSubelementType;
use Galaxy\BackendBundle\Form\Space\TypeForm;
use Galaxy\BackendBundle\Form\Space\TypeCoordType;



class PrizeSegmentController extends Controller
{
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
        $points = $this->container->getParameter('points.in.space');
        $segmentsForm = array();

        foreach ($allSegments as $oneSegment) {
            $segmentsForm[$oneSegment->id] = $this->createForm(new SegmentType(), $oneSegment)
            ->createView();
        }
        
        
        return array(
            'points' => $points,
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
     * @Template()
     * @param type $id
     * @return type
     */
    public function prizeSegmentConfigAction($id)
    {
        $segmentService = $this->container->get('remote.service');
        $entity = $segmentService->getElementsOnPrizeSegment($id);
        $segmentLength = $entity->length;
        $newForm = $this->createForm(new PrizeSubelementType());
        $prizes = array();
        $forms = array();
        $count= 0;
        
        foreach ($entity->prizes as $prize){
            $prizes[$prize->id] = array();
            foreach ($prize->elements as $element){
                $prizes[$prize->id][] = array("id" => $element->id, "name" => $element->name);
                foreach ($entity->subelements as $i => $subelement){
                    if($subelement->elementId == $element->id){
                        $form = $this->createForm(new PrizeSubelementType(), $subelement);
                        $forms[] = array("prize" => $prize->name, "element" => $element->name, "form" => $form->createView());
                        $count += $subelement->prizeCount;
                        unset($entity->subelements[$i]);
                    }
                }
            }
        }
        //print_r(json_encode($prizes));
        //print_r($entity->prizes);
        
        return array(
            'id' => $id,
            'forms' => $forms,
            'form' => $newForm->createView(),
            'count' => $count,
            'segmentLength' => $segmentLength,
            'prizes' => $prizes,
            'entities' => $entity->prizes,
        );
    }
    
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveSubelementAction(Request $request, $id)
    {
        return $this->saveSubelement($request, $id, "saveSubelement");
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSubelementAction(Request $request, $id)
    {
        return $this->saveSubelement($request, $id, "updateSubelement");
    }
    
    private function saveSubelement(Request $request, $id, $method)
    {
        $segment = $this->container->get('remote.service');
        $form = $this->createForm(new PrizeSubelementType(), array());
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

    public function removeSubelementAction($id)
    {
        $segment = $this->container->get('remote.service');
        
        $json = $segment->removeSubelement($id);
        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
}