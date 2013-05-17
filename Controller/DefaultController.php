<?php

namespace Galaxy\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Galaxy\BackendBundle\Menu\MenuControl;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GalaxyBackendBundle:Default:index.html.twig');
    }
    
    public function menuAction($route)
    {
        $menu = new MenuControl();
        $menu->addMenu('Общие настройки','noroute1');
        $menu->addMenu('Пространство', 'noroute2');
            $menu->addChild('Начальная загрузка', 'noroute3');
                $menu->addGrandchildren('Разбить на отрезки', 'split_into_segments', true);
                $menu->addGrandchildren('Редактирование отрезков', 'show_segments', true);
            $menu->addChild('Изминение координат', 'noroute4');
            $menu->addChild('Перегрузка', 'noroute5');
            $menu->addChild('Призы', 'noroute6');
            $menu->addChild('Точки', 'noroute7');
                $menu->addGrandchildren('Черные', 'noroute8');
                $menu->addGrandchildren('Ловушка', 'noroute9');
                $menu->addGrandchildren('+%', 'noroute10');
                $menu->addGrandchildren('-%', 'noroute11');
                $menu->addGrandchildren('Кража флипера', 'noroute12');
                $menu->addGrandchildren('Сообщения', 'noroute13');
                $menu->addGrandchildren('Точка Ноль', 'noroute14');
                $menu->addGrandchildren('Ноль очков', 'noroute15');
                $menu->addGrandchildren('Супер прыжок', 'noroute16');
        $menu->addMenu('Флиперы', 'noroute17');
        $menu->addMenu('Счета', 'noroute18');
            $menu->addChild('Кража флипера', 'noroute19');
            $menu->addChild('Кража флипера2', 'noroute20');
            $menu->addChild('Кража флипера3', 'noroute21');
                $menu->addGrandchildren('Кража флипера4', 'noroute22');
                $menu->addGrandchildren('Кража флипера5', 'galaxy_back_end_homepage', true);
            $menu->addChild('Кража флипера6', 'noroute23');
        $menu->addMenu('Страхование', 'noroute24');
        $menu->addMenu('Администрирование', 'noroute25');
        $menu->addMenu('Отчеты', 'noroute26');
        
        
        $allMenu = $menu->getAllMenu($route);
        return $this->render('GalaxyBackendBundle:Default:menu.html.twig', array('allMenu' => $allMenu));
    }
    
    public function footerAction()
    {
        return $this->render('GalaxyBackendBundle:Default:footer.html.twig');
    }
}
