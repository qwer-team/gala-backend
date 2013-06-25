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
     * @Template()
     * @param type $id
     * @return type
     */
    public function prizeSegmentConfigAction($id)
    {
        $segmentService = $this->container->get('remote.service');
        $entity = $segmentService->getOnPrizeSegment($id);
        $segmentLength = $entity->length;
        $types = array();
        $count= 0;
        
        foreach ($entity->types as $type) {
            $type->subtypes = array();
            $new = array("typeId" => $type->id);
            $type->form = array($this->createForm(new SubtypeType(), $new)->createView());
            $types[$type->id] = $type;
        }

        foreach ($entity->subelements as $subtypes) {
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
}