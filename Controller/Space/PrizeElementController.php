<?php

namespace Galaxy\BackendBundle\Controller\Space;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Galaxy\BackendBundle\Form\Space\PrizeElementType;
use Galaxy\BackendBundle\Form\Space\SubelementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PrizeElementController extends Controller
{

    /**
     * @Template()
     */
    public function editAction($id)
    {
        $service = $this->container->get('remote.service');
        $element = $service->getPrizeElement($id);

        $form = $this->createForm(new PrizeElementType, $element);

        return array(
            "form" => $form->createView(),
            "element" => $element,
        );
    }

    public function updateAction($id, Request $request)
    {
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
                }
            }
            $service->updatePrizeElement($id, $data);
        }

        $url = $this->generateUrl("element_edit", array("id" => $id));
        return $this->redirect($url);
    }

    /**
     * @Template()
     */
    public function createAction($prizeId)
    {
        $form = $this->createForm(new PrizeElementType);

        return array(
            "form" => $form->createView(),
            "prizeId" => $prizeId,
        );
    }

    public function addAction($prizeId, Request $request)
    {
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

    public function deleteAction($prizeId, $id)
    {
        $service = $this->container->get('remote.service');
        $service->deletePrizeElement($id);

        $url = $this->generateUrl('prize_list', array('id' => $prizeId));
        return $this->redirect($url);
    }

    /**
     * @Template()
     */
    public function loadAction()
    {
        $service = $this->container->get('remote.service');
        $subelements = $service->getSubelementsSingleList();

        foreach ($subelements as $subelement) {
            list($x, $y, $z) = $this->getCoords($subelement->pointId);
            $data = array(
                "x" => $x,
                "y" => $y,
                "z" => $z,
                "element" => $subelement->elementId,
            );
            $form = $this->createForm(new SubelementType(), $data);
            $subelement->form = $form->createView();
        }
        
        return array(
            "subelements" => $subelements,
        );
    }

    private function getCoords($id)
    {
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

}