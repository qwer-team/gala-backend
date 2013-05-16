<?php

namespace Galaxy\BackEndBundle\Controller\Space;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Galaxy\BackEndBundle\Form\Space\SplitIntoSegmentType;
use Galaxy\BackEndBundle\Form\Space\SegmentType;
use Symfony\Component\HttpFoundation\Response;
use Galaxy\BackEndBundle\Form\Space\SubtypeGroupType;

class BootstrapController extends Controller
{

    /**
     * @Template()
     * @return type
     */
    public function splitIntoSegmentsAction()
    {
        $SplitIntoSegmentForm = $this->createForm(new SplitIntoSegmentType())
                ->createView();
        return array(
            'splitIntoSegmentForm' => $SplitIntoSegmentForm,
        );
    }

    /**
     * @Template("GalaxyBackEndBundle:Space\Bootstrap:downloadSection.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function updateSplitIntoSegmentAction(Request $request)
    {
        $form = $this->createForm(new SplitIntoSegmentType());
        $form->bind($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $count = $data["count"];
            $segment = $this->container->get('segment.service');

            if ($segment->updateSplitIntoSegment($count)) {
                return $this->redirect($this->generateUrl('show_segments'));
            }
        }
        return array();
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
    public function showPointsOnSegmentAction($id)
    {
        $segment = $this->container->get('segment.service');
        $entity = $segment->getPointsOnSegment($id);
        $types = array();
        foreach($entity->types as $type){
            $type->subtypes = array();
            $types[$type->id] = $type;
        }
        
        foreach($entity->subtypes as $subtypes){
            $typeId = $subtypes->typeId;
            $types[$typeId]->subtypes[] = $subtypes;
        }
        foreach ($types as $oneType) {
           $typesForm[$oneType->id] = $this->createForm(new SubtypeGroupType(), $oneType)->createView(); 
        }
        
        return array(
            'id' => $id,
            'typesForm' => $typesForm,
            'types' => $types,
        );
    }

    /**
     * @param type $id
     * @return type
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveSubtypeAction(Request $request, $typeId)
    {
        $segment = $this->container->get('segment.service');
            $form = $this->createForm(new PointsSubtypeType());
        $form->bind($request);
        $json = array();
        if ($form->isValid()) {
            $data = $form->getData();
            $json = $segment->saveSubtype($typeId, $data);
        } else {
            print_r($form->getErrors());
        }
        $json->id = $id;
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
