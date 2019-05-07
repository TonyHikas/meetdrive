<?php
namespace application\controllers;
use application\core\Controller;

class AdminController extends Controller {

    public function loginAction(){
        $this->view->layout = 'admin';//layout админки
        //debug($this->route['id']);
        $login = $this->view->adminLogin;
        $password = $this->view->adminPass;
        if (!empty($_POST)){
            if ($_POST['login']==$login){
                if ($_POST['password']==$password){
                    $_SESSION['adminLogin'] = $_POST['login'];
                    $_SESSION['adminPass'] = $_POST['password'];
                    $this->view->location('/admin');//редирект при успешной отправки формы
                }
            }
            $this->view->message('error','Неверные данные');//сообщение о неверно заполненной формы
        }
        $this->view->render('Вход');
    }

    public function mainAction(){
        $this->view->layout = 'admin';//layout админки
        if ($this->view->checkAdmin()){
        $vars = [
            'log'=>$this->view->checkAdmin(),//параметры для передачи в render, внутри превратится в $log
        ];
        $this->view->render('Админка',$vars);
        }else{
            $this->view->redirect('/admin/login');//редирект
        }
    }

    public function logoutAction(){
        $_SESSION['adminLogin']='';
        $_SESSION['adminPass'] ='';
        $this->view->redirect(login);
    }

    public function paramsAction()
    {
        if ($this->view->checkAdmin()) {
            $this->view->layout = 'admin';//layout админки
            $vars = [
                'params' => $this->allParams,//параметры для передачи в render, внутри превратится в $log
            ];
            $this->view->render('Параметры', $vars);
        }else{
            $this->view->redirect('/admin/login');//редирект
        }
    }
    public function editParamsAction(){
        if ($this->view->checkAdmin()){
            $this->view->layout = 'admin';
            $res = $this->paramModel->getOneParam($this->route['id']);
            $vars = [
                'oneParam'=>$res,//параметры для передачи в render, внутри превратится в $log
            ];
            $this->view->render('Изменить параметры',$vars);
        }else{
            $this->view->redirect('/admin/login');//редирект
        }
    }
    public function editParamsGoAction()
    {
        if ($this->view->checkAdmin()) {
            if (!empty($_POST)) {
                $this->paramModel->editParam($_POST['id'], $_POST['value']);
                $this->view->location('/admin/params');
            }
        }else{
            $this->view->redirect('/admin/login');//редирект
        }
    }

}