<?php
namespace application\controllers;
use application\core\Controller;

class GlavController extends Controller {


    public function indexAction(){
        $vars = [
            'params'=>$this->params,
        ];
        $this->view->render('Моя главная страница',$vars);
    }
    public function getUser($id){
        $result = $this->loadModel('user')->getUserById($id);
        return $result;
    }
    public function allAction(){
        if (isset($this->route['page'])){
            $page = $this->route['page'];
        }else{
            $page=1;
        }
        $events = $this->model->getAllEvents($page);

        $ready_events = [];
        foreach ($events['rows'] as $event){
            $us = $this->getUser($event['creator_id']);
            array_push($ready_events, [
                'company'=>$us['company'],
                'company_confirm'=>$us['company_confirm'],
                'nazv'=>$event['nazv'],
                'alias'=>$event['alias'],
                'start_date'=>$this->rdate("d M Yг.",$event['start_date']),
                'start_time'=>date("G:i",$event['start_date']),
                'category'=>$event['category'],
                'transport_type'=>$event['transport_type'],
                'city'=>$event['city'],
                'event_type'=>$event['event_type'],
                'price'=>$event['price'],
                'adress'=>$event['adress'],
            ]);

        }
        $count = $events['count'];
        $max_page = ceil($count/20);
        $vars = [
            'events'=>$ready_events,
            'params'=>$this->params,
            'page'   => $page,
            'max_page'=>$max_page,
            'count'=>$count,
        ];
        $this->view->render('Все сходки',$vars);
    }
    public function eventAction(){
        $event = $this->model->getEventByAlias($this->route['alias']);
        if ($event != false){
            $us = $this->getUser($event['creator_id']);
            $is_creator = false;
            $uchastniki_podt=[];
            $uchastniki_nepodt=[];
            if ($event['creator_id'] == $_SESSION['id']){
                $is_creator = true;
                $uchastniki_podt = $this->model->getUchast($event['id'],true);
                $uchastniki_nepodt = $this->model->getUchast($event['id'],false);
            }
            $red_event = [
                'company'=>$us['company'],
                'company_confirm'=>$us['company_confirm'],
                'nazv'=>$event['nazv'],
                'alias'=>$event['alias'],
                'opis'=>$event['opis'],
                'start_date'=>$this->rdate("d M Yг.",$event['start_date']),
                'start_time'=>date("G:i",$event['start_date']),
                'category'=>$event['category'],
                'transport_type'=>$event['transport_type'],
                'city'=>$event['city'],
                'event_type'=>$event['event_type'],
                'price'=>$event['price'],
                'adress'=>$event['adress'],
                'type'=>$event['type'],
            ];
            $vars = [
                'uchastniki_podt'=>$uchastniki_podt,
                'uchastniki_nepodt'=>$uchastniki_nepodt,
                'is_creator'=>$is_creator,
                'params'=>$this->params,
                'event'=>$red_event,
                'ispodt'=>$this->isPodt,
                'avtos'=>$this->loadModel('avto')->getUserAvtos($_SESSION['id']),
                'alias'=>$this->route['alias'],
                'isUch'=>$this->loadModel('uchastie')->checkUchastie($_SESSION['id'],$event['id']),


            ];
            $creator_us = $this->loadModel('user')->getUserById($event['creator_id']);
            $this->view->render($event['nazv'].' - '.$creator_us['company'],$vars);
        }else{
            $this->view->errorCode(404);
        }
    }

    public function enterAction(){
        $this->accessLevel(2);//уровень доступа(В данном случае только пользователи с  подтверждённым email)
            if (!empty($_POST)) {
                $uch = $this->loadModel('uchastie');
                $event = $this->model->getEventByAlias($this->route['alias']);
                if ($event['start_date']>time()){
                    if ($event['creator_id']!=$_SESSION['id']) {
                        $avto = $this->loadModel('avto')->getOneAvto($_POST['avto_id'], $_SESSION['id']);
                        if ($uch->checkUchastie($_SESSION['id'],$event['id']) == false) {
                            if ($avto != false) {
                                switch ($event['type']){
                                    case 1:
                                        $uch->newUchastie($_SESSION['id'], $event['id'], $_POST['avto_id'],$event['start_date'],0);
                                        $this->view->location('/event/' . $this->route['alias']);
                                        break;
                                    case 2:
                                        $uch->newUchastie($_SESSION['id'], $event['id'], $_POST['avto_id'],$event['start_date'],1);
                                        $this->view->location('/event/' . $this->route['alias']);
                                        break;
                                    case 3:
                                        $checkCode = $uch->checkCode($_POST['code'],$event['id']);
                                        if ($checkCode != false){
                                            $uch->codeUse($_POST['code'],$event['id']);
                                            $uch->newUchastieCode($_SESSION['id'], $event['id'], $_POST['avto_id'],$event['start_date'],1,$_POST['code']);
                                            $this->view->location('/event/' . $this->route['alias']);
                                        }else{
                                            $this->view->message('error', 'Неверный или не существующий код');
                                        }
                                        break;
                                    default:
                                        $this->view->message('error', 'Неизвестный тип мероприятия');
                                }
                            } else {
                                $this->view->message('error', 'Авто не существует или пренадлежит не вам');
                            }
                        } else {
                            $this->view->message('error', 'Вы уже участвуете');
                        }
                    }else{
                        $this->view->message('error', 'Вы являетесь создателем');
                    }
                }else{
                    $this->view->message('error', 'Мероприятие закончилось');
                }


            } else {
                $this->view->redirect('/all');
            }

    }

    public function editAction(){
        $this->accessLevel(2);
            if (!empty($_POST)) {
                $uch = $this->loadModel('uchastie');
                $event = $this->model->getEventByAlias($this->route['alias']);
                if ($event['start_date']>time()){
                    if ($event['creator_id']!=$_SESSION['id']) {
                        $avto = $this->loadModel('avto')->getOneAvto($_POST['avto_id'], $_SESSION['id']);
                        $checkUch = $uch->checkUchastie($_SESSION['id'],$event['id']);
                        if ($checkUch != false) {
                            if ($avto != false) {
                                if ($avto['id']!=$checkUch['avto_id']){
                                    $uch->updateUchastie($_SESSION['id'], $event['id'], $_POST['avto_id'], $event['type']);
                                    $this->view->location('/event/' . $this->route['alias']);
                                }else{
                                    $this->view->message('error', 'Авто уже участвует');
                                }

                            } else {
                                $this->view->message('error', 'Авто не существует или пренадлежит не вам');
                            }
                        } else {
                            $this->view->message('error', 'Вы не участвуете');
                        }
                    }else{
                        $this->view->message('error', 'Вы являетесь создателем');
                    }
                }else{
                    $this->view->message('error', 'Мероприятие закончилось');
                }


            } else {
                $this->view->redirect('/all');
            }

    }
    public function exitAction(){
        $this->accessLevel(2);
            if (!empty($_POST)) {
                $uch = $this->loadModel('uchastie');
                $event = $this->model->getEventByAlias($this->route['alias']);
                if ($event['start_date']>time()){
                    if ($event['creator_id']!=$_SESSION['id']) {
                        $checkUch = $uch->checkUchastie($_SESSION['id'],$event['id']);
                        if ($checkUch != false) {
                            if ($event['type']==3){
                                $uch->exitUchastie($_SESSION['id'], $event['id'],$checkUch['podt_key']);
                                $this->view->location('/event/' . $this->route['alias']);
                            }else{
                                $uch->exitUchastie($_SESSION['id'], $event['id'], false);
                                $this->view->location('/event/' . $this->route['alias']);
                            }
                        } else {
                            $this->view->message('error', 'Вы не участвуете');
                        }
                    }else{
                        $this->view->message('error', 'Вы являетесь создателем');
                    }
                }else{
                    $this->view->message('error', 'Мероприятие закончилось');
                }


            } else {
                $this->view->redirect('/all');
            }
    }


}