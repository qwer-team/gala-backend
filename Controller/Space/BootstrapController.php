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

class BootstrapController extends Controller {

    /**
     * @Template()
     * @return type
     */
    public function segmentsAction() {
        $type = new SplitType();
        $segmentService = $this->container->get('remote.service');
        $allSegments = $segmentService->getSegments();
        $countSegments = count($allSegments);
        $form = $this->createForm($type);
        $form->setData(
                array('count' => $countSegments)
        );
        return array(
            'splitIntoSegmentForm' => $form->createView(),
        );
    }

    /**
     * @Template("GalaxyBackendBundle:Space\Bootstrap:segments.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function splitAction(Request $request) {
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
    public function showSegmentsAction() {
        $segment = $this->container->get('remote.service');
        $allSegments = $segment->getSegments();
        $points = $this->container->getParameter('points.in.space');
        $segmentsForm = array();

        foreach ($allSegments as $oneSegment) {
            $segmentsForm[$oneSegment->id] = $this->createForm(new SegmentType(), $oneSegment)
                    ->createView();
        }

        return array(
            'points' => $points,
            'segments_form' => $segmentsForm,
            'allSegments' => $allSegments);
    }

    /**
     * @Template()
     * @param type $id
     * @return type
     */
    public function segmentConfigAction($id) {
        $segmentService = $this->container->get('remote.service');
        $entity = $segmentService->getPointsOnSegment($id);
        $segmentLength = $entity->length;
        $types = array();
        $count = 0;

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
    public function saveSubtypeAction(Request $request, $id) {
        return $this->saveSubtype($request, $id, "saveSubtype");
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSubtypeAction(Request $request, $id) {
        return $this->saveSubtype($request, $id, "updateSubtype");
    }

    private function saveSubtype(Request $request, $id, $method) {
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

    public function removeSubtypeAction($id) {
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
    public function updateSegmentLengthAction(Request $request, $id) {
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
    public function loadingAction() {
        $segment = $this->container->get('remote.service');
        $grailsServer = $this->container->getParameter("grails.server");
        $allSegments = $segment->getSegments();

        return array(
            'segments' => $allSegments,
            "grailsServer" => $grailsServer,
        );
    }

    /**
     * @Template()
     */
    public function typeConfigAction($tag, Request $request) {
        $typeService = $this->container->get('remote.service');
        $type = $typeService->getType($tag);
        $form = $this->createForm(new TypeForm(), $type);
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $response = $typeService->updateType($this->dataFileProcessing($data, $type));
                if($response->result == 'success'){
                    $url = $this->generateUrl("type_config", array("tag" => $tag));
                    return $this->redirect($url);
                }
            }
        }
        
        return array(
            'tag' => $tag,
            'type' => $type,
            'form' => $form->createView(),
        );
    }

    

    private function dataFileProcessing($data, $type) {
        $storage = $this->get("storage");
        for ($i = 1; $i <= 4; $i++) {
            $file = $data['fl' . $i];
            if (!is_null($file)) {
                $path = $storage->save($file);
                unset($data['fl' . $i]);
                $data['file' . $i] = $path;
            } elseif ($data['fileDelete' . $i] && array_key_exists("file" . $i, $type)) {
                $storage->delete($type['file' . $i]);
                $data['file' . $i] = "";
                $data['fileDelete' . $i] = false;
            }
        }
        return $data;
    }

   

    /**
     * @Template()
     */
    public function changeCoordsAction() {
        $typeService = $this->container->get('remote.service');
        $rawTypes = $typeService->getTypeList();
        $types = array();
        foreach ($rawTypes as $type) {
            $typeArr = array();
            $form = $this->createForm(new TypeCoordType(), (array) $type);

            $typeArr["type"] = $type;
            $typeArr["form"] = $form->createView();
            $types[] = $typeArr;
        }


        return array("types" => $types);
    }

    public function updateCoordsAction(Request $request) {
        $form = $this->createForm(new TypeCoordType());
        $form->bindRequest($request);

        $result = json_encode(array("result" => "fail"));
        if ($form->isValid()) {
            $data = $form->getData();
            $typeService = $this->container->get('remote.service');
            $result = $typeService->updateCoords($data);
        }

        $response = new Response();
        $response->setContent(json_encode($result));

        return $response;
    }

}
