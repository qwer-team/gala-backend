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
    
    public function menuAction($route, $params)
    {
        $menu = new MenuControl();
        $menu->addMenu('Главная','galaxy_back_end_homepage');
        $menu->addMenu('Стартовая','start_page',true);
        $menu->addMenu('Общие настройки','noroute1');
        $menu->addMenu('Пространство', 'noroute2');
            $menu->addChild('Начальная загрузка', 'noroute3');
                $menu->addGrandchildren('Разбить на отрезки', 'segments', true);
                $menu->addGrandchildren('Редактирование отрезков', 'show_segments', true);
                $menu->addGrandchildren('Загрузка', 'space_loading', true);
            $menu->addChild('Изминение координат', 'change_coordinates', true);
            $menu->addChild('Перегрузка', 'noroute5');
            $menu->addChild('Призы', 'noroute27');
                $menu->addGrandchildren('Разбить на отрезки', 'prize_segments', true);
                $menu->addGrandchildren('Редактирование отрезков', 'show_prize_segments', true);
                $menu->addGrandchildren('Список призов', 'prize_list', true);
                $menu->addGrandchildren('Ручная загрузка', 'element_load_list', true);
                $menu->addGrandchildren('Изменение координат', 'element_change_coords', true);
                $menu->addGrandchildren('Загрузка', 'prize_loading', true);
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
            $menu->addChild('Первый', 'flipper_show', true, array("id" => 1));
            $menu->addChild('Второй', 'flipper_show', true, array("id" => 2));
            $menu->addChild('Третий', 'flipper_show', true, array("id" => 3));
            $menu->addChild('Четвертый', 'noroute22');
            $menu->addChild('Пятый', 'noroute23');
        $menu->addMenu('Счета', 'noroute18');
            $menu->addChild('Активный', 'show_register', true, array("id" => 1));
            $menu->addChild('Безопасный', 'show_register', true, array("id" => 2));
            $menu->addChild('Депозитный', 'show_register', true, array("id" => 3));

            $menu->addChild('Транзитный активный', 'show_register', true, array("id" => 4));
            $menu->addChild('Транзитный безопасный', 'show_register', true, array("id" => 5));

            $menu->addChild('Курс', 'show_rate', true);

        $menu->addMenu('Страхование', 'noroute24');
        $menu->addMenu('Администрирование', 'noroute25');
        $menu->addMenu('Документы', 'noroute26');
            $menu->addChild('Зачисление средств', 'document_list', true, array("type" => 'fundsTransfer'));
            $menu->addChild('Списание средств', 'document_list', true, array("type" => 'servicesDebit'));
        $menu->addMenu('Отчеты', 'noroute26');
        
        
        $allMenu = $menu->getAllMenu($route, $params);
        return $this->render('GalaxyBackendBundle:Default:menu.html.twig', array('allMenu' => $allMenu));
    }
    
    public function contentAction($route, $params)
    {
        $menu = new MenuControl();
        $menu->addMenu('Сообщения', 'noroute1');
            $menu->addChild('Список', 'messages_list', true);
               
        $allMenu = $menu->getAllMenu($route, $params);
        return $this->render('GalaxyBackendBundle:Default:menu.html.twig', array('allMenu' => $allMenu));
    }


    public function footerAction()
    {
        return $this->render('GalaxyBackendBundle:Default:footer.html.twig');
    }
    
    public function startPageAction()
    {
        return $this->render('GalaxyBackendBundle:Default:startPage.html.twig');
    }
            
}
