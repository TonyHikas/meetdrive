<?php
namespace application\controllers;
use application\core\Controller;

class AvtoController extends Controller
{
    public function __construct($route)
    {

        parent::__construct($route);
        $this->accessLevel(2);//уровень доступа для всего контроллера
    }

    public function myavtoAction()
    {
        if (isset($this->route['page'])){
            $page = $this->route['page'];
        }else{
            $page=1;
        }
        if ($this->isPodt) {
            $avtos = $this->model->getUserAvtosPage($_SESSION['id'],$page);
            $count = $avtos['count'];
            $max_page = ceil($count/20);
            $vars = [
                'params' => $this->params,
                'avtos' => $avtos['rows'],
                'page'   => $page,
                'max_page'=>$max_page,
                'count'=>$count,
            ];
            $this->view->render('Мои авто', $vars);
        } else {
            $this->view->redirect('/profile/login');
        }
    }

    public function editAvtoAction()
    {
        if ($this->isPodt) {
            if (!empty($_POST)) {
                $avto = $this->model->getOneAvto($_POST['id'], $_SESSION['id']);
                if ($avto != false) {
                    $this->model->editAvto($_POST['id'], $_POST['brand'], $_POST['model'], $_POST['type'], $_POST['opis']);
                    $this->view->location('/profile/myavto');
                } else {
                    $this->view->message('error', 'Ошибка доступа');
                }
            } else {
                if (isset($this->route['id'])) {
                    $avto = $this->model->getOneAvto($this->route['id'], $_SESSION['id']);
                    if ($avto != false) {
                        $vars = [
                            'params' => $this->params,
                            'avto' => $avto,
                        ];
                        $this->view->render('Редактировать авто', $vars);
                    } else {
                        echo 'Ошибка';
                    }
                } else {
                    echo 'Ошибка';
                }

            }


        } else {
            if (!empty($_POST)) {
                $this->view->location('/profile/login');
            }
            $this->view->redirect('/profile/login');
        }
    }

    public function addAvtoAction()
    {
        //добавить проверку на существование мадели бренда и типа + сделать очищение html тегов в opis
        if ($this->isPodt) {
            if (!empty($_POST)) {
                $input_model = $this->loadModel('input');
                if ($_POST['brand'] == '') {
                    $this->view->message('error', 'Неверный бренд');
                }
                if ($_POST['model'] == '') {
                    $this->view->message('error', 'Неверная модель');
                }
                if ($input_model->checkCar($_POST['brand'],$_POST['model'])!=true){
                    $this->view->message('error', 'Бренд/модель не существует');
                }
                if ($_POST['type'] == '') {
                    $this->view->message('error', 'Неверный тип');
                }
                $this->model->addAvto($_SESSION['id'], $_POST['brand'], $_POST['model'], $_POST['type'], $_POST['opis']);
                $this->view->location('/profile/myavto');
            } else {
                $vars = [
                    'params' => $this->params,
                ];
                $this->view->render('Добавить авто', $vars);
            }
        } else {
            if (!empty($_POST)) {
                $this->view->location('/profile/login');
            }
            $this->view->redirect('/profile/login');
        }
    }
    public function deleteAvtoAction(){
        if ($this->isPodt) {
                $avto = $this->model->getOneAvto($this->route['id'], $_SESSION['id']);
                if ($avto != false) {
                    $this->model->deleteAvto($this->route['id'],$avto);
                    $this->view->redirect('/profile/myavto');
                } else {
                    echo 'Ошибка доступа';
                }



        } else {
            $this->view->redirect('/profile/login');
        }
    }





}