<?php

namespace Galaxy\BackendBundle\Controller\Space;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Galaxy\BackendBundle\Form\Space\PrizeElementType;
use Galaxy\BackendBundle\Form\Space\PrizeElementsCoordsType;
use Galaxy\BackendBundle\Form\Space\SubelementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PrizeElementController extends Controller {

    /**
     * @Template()
     */
    public function editAction($id) {
        $service = $this->container->get('remote.service');
        $element = $service->getPrizeElement($id);

        $form = $this->createForm(new PrizeElementType, $element);

        return array(
            "form" => $form->createView(),
            "element" => $element,
        );
    }

    public function updateAction($id, Request $request) {
        $service = $this->container->get('remote.service');
        $element = $service->getPrizeElement($id);

        $form = $this->createForm(new PrizeElementType, $element);
        $form->bind($request);
        if ($form->isValid()) {
            $data = $form->getData();

            $storage = $this->get("storage");
            for ($i = 1; $i <= 2; $i++) {
                $img = $data['imgfile' . $i];
                if (!is_null($img)) {
                    $path = $storage->save($img);
                    $data['img' . $i] = $path;
                    unset($data['imgfile' . $i]);
                } elseif ($data['imgDelete' . $i]) {
                    $storage->delete($data['imgfile' . $i]);
                    $data['img' . $i] = "";
                }
                unset($data['imgDelete' . $i]);
            }

            $service->updatePrizeElement($id, $data);
        } else {
            echo $form->getErrorsAsString();
        }

        $url = $this->generateUrl("element_edit", array("id" => $id));
        return $this->redirect($url);
    }

    /**
     * @Template()
     */
    public function createAction($prizeId) {
        $form = $this->createForm(new PrizeElementType);

        return array(
            "form" => $form->createView(),
            "prizeId" => $prizeId,
        );
    }

    public function addAction($prizeId, Request $request) {
        $form = $this->createForm(new PrizeElementType);

        $form->bind($request);
        if ($form->isValid()) {
            $data = $form->getData();

            $storage = $this->get("storage");
            for ($i = 1; $i <= 2; $i++) {
                $img = $data['imgfile' . $i];
                if (!is_null($img)) {
                    $path = $storage->save($img);
                    $data['img' . $i] = $path;
                    unset($data['imgfile' . $i]);
                }
            }
            $service = $this->container->get('remote.service');
            $id = $service->addPrizeElement($prizeId, $data);
        }

        $url = $this->generateUrl("element_edit", array("id" => $id));
        return $this->redirect($url);
    }

    public function deleteAction($prizeId, $id) {
        $service = $this->container->get('remote.service');
        $service->deletePrizeElement($id);

        $url = $this->generateUrl('prize_list', array('id' => $prizeId));
        return $this->redirect($url);
    }

    /**
     * @Template()
     */
    public function loadListAction() {
        $service = $this->container->get('remote.service');
        $subelements = $service->getSubelementsSingleList();
        $prizesList = $service->getPrizesList();
        $prizes = array();
        $forms = array();

        foreach ($prizesList as $prize) {
            $prizes[$prize["id"]] = array();
            foreach ($prize["elements"] as $element) {
                $prizes[$prize["id"]][] = array("id" => $element["id"], "name" => $element["name"]);
                foreach ($subelements as $i => $subelement) {
                    if ($subelement->elementId == $element["id"]) {
                        list($x, $y, $z) = $this->getCoords($subelement->pointId);
                        $data = array(
                            "x" => $x,
                            "y" => $y,
                            "z" => $z,
                            "element" => $subelement->elementId,
                        );
                        $form = $this->createForm(new SubelementType(), $data);
                        $forms[] = array("prize" => $prize["name"], "element" => $element["name"], "form" => $form->createView(), "id" => $subelement->id);
                        unset($subelements[$i]);
                    }
                }
            }
        }

        return array(
            "subelements" => $subelements,
            "prizes" => $prizes,
            'forms' => $forms,
            'entities' => $prizesList,
            "newForm" => $this->createForm(new SubelementType())->createView(),
        );
    }

    /**
     * @Template()
     */
    public function changeCoordsAction() {
        $service = $this->container->get('remote.service');
        $prizes = $service->getPrizesList();

        $elements = array();
        foreach ($prizes as $prize) {
            foreach ($prize['elements'] as $prizeElement) {
                $type = new PrizeElementsCoordsType();
                $form = $this->createForm($type, $prizeElement);
                $elements[] = array(
                    "form" => $form->createView(),
                    "prize" => $prize["name"],
                    "element" => $prizeElement,
                );
            }
        }

        return array(
            "elements" => $elements,
        );
    }

    public function saveChangeCoordsAction($id, request $request) {
        $form = $this->createForm(new PrizeElementsCoordsType());
        $form->bind($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $service = $this->container->get('remote.service');
            $service->updateElementCoords($id, $data);
        }

        $url = $this->generateUrl("element_change_coords");
        return $this->redirect($url);
    }

    public function addSingleSubelementAction(Request $request) {
        return $this->saveLoading($request);
    }

    public function updateSingleSubelementAction($id, Request $request) {
        return $this->saveLoading($request, $id);
    }

    private function saveLoading(Request $request, $id = null) {
        $form = $this->createForm(new SubelementType());
        $form->bind($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $x = $data['x'];
            $y = $data['y'];
            $z = $data['z'];

            $pointId = $this->getId($x, $y, $z);
            $element = $data["element"];

            $requestData = array(
                'pointId' => $pointId,
                'element' => $element,
            );

            $service = $this->container->get('remote.service');
            if (is_null($id)) {
                $service->loadAddPrize($requestData);
            } else {
                $service->loadUpdatePrize($id, $requestData);
            }
        } else {
            echo $form->getErrorsAsString();
        }

        $url = $this->generateUrl("element_load_list");
        return $this->redirect($url);
    }

    private function getCoords($id) {
        $id--;
        $x = $id % 1000;
        $id -= $x;
        $x++;

        $y = $id % 1000000 / 1000;
        $id -= $y * 1000;
        $y++;
        $z = $id % 1000000000 / 1000000;
        $z++;

        return array($x, $y, $z);
    }

    private function getId($x, $y, $z) {
        $id = $x + ($y - 1) * 1000 + ($z - 1) * 1000000;

        return $id;
    }

}