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
                $menu->addGrandchildren('Разбить на отрезки', 'segments', true);
                $menu->addGrandchildren('Редактирование отрезков', 'show_segments', true);
                $menu->addGrandchildren('Загрузка', 'space_loading', true);
            $menu->addChild('Изминение координат', 'noroute4');
            $menu->addChild('Перегрузка', 'noroute5');
            $menu->addChild('Призы', 'noroute6');
            $menu->addChild('Точки', 'noroute7');
                $menu->addGrandchildren('Черные', 'type_config', true, array('tag' => 'black'));
                $menu->addGrandchildren('Ловушка', 'type_config', true, array('tag' => 'trap'));
                $menu->addGrandchildren('+%', 'type_config', true, array('tag' => 'plus_percent'));
                $menu->addGrandchildren('-%', 'type_config', true, array('tag' => 'minus_percent'));
                $menu->addGrandchildren('Кража флипера', 'type_config', true, array('tag' => 'theft'));
                $menu->addGrandchildren('Сообщения', 'type_config', true, array('tag' => 'message'));
                $menu->addGrandchildren('Точка Ноль', 'type_config', true, array('tag' => 'zero_point'));
                $menu->addGrandchildren('Ноль очков', 'type_config', true, array('tag' => 'nil'));
                $menu->addGrandchildren('Супер прыжок', 'type_config', true, array('tag' => 'jump'));
                $menu->addGrandchildren('+Период приза', 'type_config', true, array('tag' => 'plus_prize_period'));
                $menu->addGrandchildren('-Период приза', 'type_config', true, array('tag' => 'minus_prize_period'));
                $menu->addGrandchildren('+Период для всех', 'type_config', true, array('tag' => 'plus_all_period'));
                $menu->addGrandchildren('-Период для всех', 'type_config', true, array('tag' => 'minus_all_period'));
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
