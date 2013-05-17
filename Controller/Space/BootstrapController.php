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

class BootstrapController extends Controller
{

    /**
     * @Template()
     * @return type
     */
    public function segmentsAction()
    {
        $type = new SplitType();
        $formView = $this->createForm($type)->createView();
        return array(
            'splitIntoSegmentForm' => $formView,
        );
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
            $segment = $this->container->get('segment.service');

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
        $segment = $this->container->get('segment.service');
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
        $segment = $this->container->get('segment.service');
        $entity = $segment->getPointsOnSegment($id);
        $types = array();
        foreach ($entity->types as $type) {
            $type->subtypes = array();
            $types[$type->id] = $type;
        }

        foreach ($entity->subtypes as $subtypes) {
            $typeId = $subtypes->typeId;
            $types[$typeId]->subtypes[] = $subtypes;
        }

        return array(
            'id' => $id,
            'types' => $types,
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveSubtypeAction(Request $request, $id)
    {
        $segment = $this->container->get('segment.service');
        $form = $this->createForm(new SubtypeType());
        $form->bind($request);
        $json = array();
        if ($form->isValid()) {
            $data = $form->getData();
            $json = $segment->saveSubtype($id, $data);
        } 
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
        $segment = $this->container->get('segment.service');
        $form = $this->createForm(new SegmentType());
        $form->bind($request);
        $json = array();
        if ($form->isValid()) {
            $data = $form->getData();

            $length = $data["length"];
            //$percent = $data["percent"];
            $json = $segment->updateSegmentLength($id, $length);
        } else {
            print_r($form->getErrors());
        }
        $json->id = $id;
        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }

}
