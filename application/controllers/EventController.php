<?php
namespace application\controllers;
use application\core\Controller;

class EventController extends Controller {
    public function __construct($route)
    {
        parent::__construct($route);
        $this->accessLevel(2);//уровень доступа для всего контроллера
    }

    public function myeventAction(){
        $this->getMyEvents(true);
    }
    public function archivemyeventAction(){
        $this->getMyEvents(false);
    }
    public function dopis($events){
        $ready_events = [];
        $mod = $this->loadModel('user');
        foreach ($events as $event){
            $us = $mod->getUserById($event['creator_id']);
            array_push($ready_events, [
                'id'=>$event['id'],
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
        return $ready_events;
    }
    public function getMyEvents($is_active){
        if (isset($this->route['page'])){
            $page = $this->route['page'];
        }else{
            $page=1;
        }

        if ($this->curUser['company']!=''){
            $ret = $this->model->getUserEvents($_SESSION['id'],$is_active,$page);
            $events_to_dopis = $ret['rows'];
            $ready_events = $this->dopis($events_to_dopis);

            $count = $ret['count'];
            $max_page = ceil($count/20);
            $vars = [
                'params' => $this->params,
                'events' => $ready_events,
                'page'   => $page,
                'max_page'=>$max_page,
                'count'=>$count,
            ];
            $this->view->render('Мои сходки',$vars);
        }else{
            echo 'Организации не существует';
        }
    }
    public function editEventAction()
    {
            if (!empty($_POST)) {
                $event = $this->model->getOneEvent($_POST['id'], $_SESSION['id']);
                if ($event != false) {
                    if ($event['start_date']< (time()+900)){
                        $this->view->message('error', 'Мероприятие закончилось');
                    }
                    if ($_POST['start_date']<time()){
                        $this->view->message('error', 'Неверная дата');
                    }
                    if ($_POST['start_date']>(time() + 31536000)){
                        $this->view->message('error', 'Дата начала не должна превышать один год от даты создания мероприятия');
                    }
                    $this->model->editEvent($_POST['id'], $_POST['nazv'], $_POST['opis'], $_POST['start_date'], $_POST['category'], $_POST['transport_type'], $_POST['city'], $_POST['event_type'], $_POST['price'], $_POST['adress']);
                    if ($event['start_date']!=$_POST['start_date']){
                        $this->model->updateStartUchastie($_POST['id'],$_POST['start_date']);
                    }
                    $this->view->location('/profile/myevent');
                } else {
                    $this->view->message('error', 'Ошибка доступа');
                }
            } else {
                if (isset($this->route['id'])) {
                    $event = $this->model->getOneEvent($this->route['id'], $_SESSION['id']);
                    if ($event != false) {
                        $vars = [
                            'params' => $this->params,
                            'event' => $event,
                        ];
                        $this->view->render('Редактировать мероприятие', $vars);
                    } else {
                        echo 'Ошибка';
                    }
                } else {
                    echo 'Ошибка';
                }

            }
    }

    public function addEventAction()
    {
        //добавить проверку на существование мадели бренда и типа + сделать очищение html тегов в opis
        if ($this->curUser['company']!='') {
            if (!empty($_POST)) {
                if ($_POST['nazv'] == '') {
                    $this->view->message('error', 'Заполните название');
                }
                if ($_POST['start_date'] == '') {
                    $this->view->message('error', 'Заполните дату начала');
                }
                if ($_POST['category'] == '') {
                    $this->view->message('error', 'Заполните категорию');
                }
                if ($_POST['adress'] == '') {
                    $this->view->message('error', 'Заполните адрес');
                }
                if ($_POST['start_date']<time()){
                    $this->view->message('error', 'Неверная дата');
                }
                if ($_POST['start_date']>(time() + 31536000)){
                    $this->view->message('error', 'Дата начала не должна превышать один год от даты создания мероприятия');
                }
                $this->model->addEvent($_SESSION['id'], $_POST['nazv'], $_POST['opis'], $_POST['start_date'], $_POST['category'], $_POST['transport_type'], $_POST['city'], $_POST['event_type'], $_POST['price'], $_POST['adress']);
                $this->view->location('/profile/myevent');
            } else {
                $vars = [
                    'params' => $this->params,
                ];
                $this->view->render('Добавить мероприятие', $vars);
            }
        } else {
            if (!empty($_POST)) {
                $this->view->location('/profile/login');
            }
            $this->view->redirect('/profile/login');
        }
    }
    public function deleteEventAction(){
            $event = $this->model->getOneEvent($this->route['id'], $_SESSION['id']);
            if ($event != false) {
                $this->model->deleteEvent($this->route['id'],$event);
                $this->view->redirect('/profile/myevent');
            } else {
                echo 'Ошибка доступа';
            }
    }

    public function createCompanyAction(){
            if ($this->curUser['company']==''){
                if (!empty($_POST)) {
                    if (trim($_POST['company'])==''){
                        $this->view->message('error', 'Заполните название');
                    }
                    $this->model->regCompany($_SESSION['id'],$_POST['company'],$_POST['link'],$_POST['opis']);
                    $this->view->location('/profile');
                }else{
                    $this->view->render('Создать организацию');
                }
            }else{
                if (!empty($_POST)) {
                    $this->view->location('/profile');
                }else {
                    $this->view->redirect('/profile');
                }
            }
    }
    public function updateCompanyAction(){
                if (!empty($_POST)) {
                    if (trim($_POST['company'])==''){
                        $this->view->message('error', 'Заполните название');
                    }
                    $this->model->updateCompany($_SESSION['id'],$_POST['company'],$_POST['link'],$_POST['opis']);
                    $this->view->location('/profile');
                }else{
                    $vars = [
                        'params' => $this->params,
                        'user' => $this->curUser,
                    ];
                    $this->view->render('Редактировать организацию',$vars);
                }
    }
    public function activeAction(){
        $ret = $this->getActiveOrArchive(true);
        if (isset($this->route['page'])){
            $page = $this->route['page'];
        }else{
            $page=1;
        }
        $ready_events = $ret['events'];
        $count = $ret['count'];
        $max_page = ceil($count/20);
        $vars = [
            'params' => $this->params,
            'events' => $ready_events,
            'page'   => $page,
            'max_page'=>$max_page,
            'count'=>$count,
        ];
        $this->view->render('Мероприятия в которых я участвую',$vars);

    }

    public function archiveAction(){
        $ret = $this->getActiveOrArchive(false);
        if (isset($this->route['page'])){
            $page = $this->route['page'];
        }else{
            $page=1;
        }

        $ready_events = $ret['events'];
        $count = $ret['count'];
        $max_page = ceil($count/20);
        $vars = [
            'params' => $this->params,
            'events' => $ready_events,
            'page'   => $page,
            'max_page'=>$max_page,
            'count'=>$count,
        ];
        $this->view->render('Мероприятия в которых я участвовал',$vars);
    }
    public function getActiveOrArchive($isActive){

            if (isset($this->route['page'])){
                $page = $this->route['page'];
            }else{
                $page=1;
            }
            $ret = $this->model->getActiveOrArchive($_SESSION['id'], $isActive, $page);
            if ($ret == false){
                return false;
            }
            $events = $ret['events'];
            $count = $ret['count'];
            $ready_events = $ready_events = $this->dopis($events);
            $ret = [
                'events' => $ready_events,
                'count'  => $count,
            ];
            return $ret;

    }







}