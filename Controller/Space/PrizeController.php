<?php

namespace Galaxy\BackendBundle\Controller\Space;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Galaxy\BackendBundle\Form\Space\PrizeType;
use Symfony\Component\HttpFoundation\Request;

class PrizeController extends Controller
{

    /**
     * @Template()
     */
    public function indexAction($id)
    {
        $service = $this->container->get('remote.service');
        $prizes = $service->getPrizesList();
        if ($id) {
            $main = $prizes[$id];
        } else {
            $values = array_values($prizes);
            $main = array_shift($values);
        }
        $form = $this->createForm(new PrizeType(), $main);

        return array(
            "prizes" => $prizes,
            "main" => $main,
            "prizeForm" => $form->createView(),
        );
    }

    public function updateAction($id, Request $request)
    {
        return $this->saveAction($request, $id);
    }

    /**
     * @Template()
     */
    public function createAction()
    {
        $form = $this->createForm(new PrizeType());

        return array(
            "form" => $form->createView(),
        );
    }

    public function addAction(Request $request)
    {
        return $this->saveAction($request);
    }

    private function saveAction(Request $request, $id = null)
    {
        $form = $this->createForm(new PrizeType());
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
            if ($id) {
                $service->updatePrize($id, $data);
            } else {
                $id = $service->addPrize($data);
            }
        }

        $url = $this->generateUrl("prize_list", array("id" => $id));
        return $this->redirect($url);
    }

    public function deleteAction($id)
    {
        $service = $this->container->get('remote.service');
        $service->deletePrize($id);
        
        $url = $this->generateUrl("prize_list");
        return $this->redirect($url);
    }

}