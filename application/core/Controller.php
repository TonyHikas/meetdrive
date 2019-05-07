<?php
namespace application\core;
use application\core\View;
abstract class Controller {

    public $route;
    public $view;
    public $allParams;
    public $params;
    public $paramModel;
    public $userModel;
    public $curUser;//текущий пользователь
    public $isPodt;//существует ли пользователь
    public $ePodt;//подтверждён ли email


    public function __construct($route){
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
        $this->paramsModel();
        $this->iniUser();
        if (!isset($_SESSION['id'])){
            $_SESSION['id']='';
        }
        if (!empty($_SESSION['login']) and !empty($_SESSION['pass'])){
            $this->curUser = $this->getUserByEmail($_SESSION['login']);
            if ($this->curUser != false){
                if ($this->curUser['pass']==$_SESSION['pass']){
                        $this->isPodt = true;
                        $_SESSION['id']=$this->curUser['id'];
                    if ($this->curUser['pod_email']==1){
                        $this->ePodt = true;
                    }else{
                        $this->ePodt = false;
                    }


                }else{
                    $this->isPodt = false;
                }
            }else{
                $this->isPodt = false;
            }

        }else{
            $this->isPodt = false;
        }
    }

    public function accessLevel($level){
        switch ($level){
            case 1:
                if (!$this->isPodt){
                    if (!empty($_POST)){
                        $this->view->location('/profile/login');
                    }else{
                        $this->view->redirect('/profile/login');
                    }
                }
                break;
            case 2:
                if (!$this->isPodt){
                    if (!empty($_POST)){
                        $this->view->location('/profile/login');
                    }else{
                        $this->view->redirect('/profile/login');
                    }
                }
                if (!$this->ePodt){
                    if (!empty($_POST)){
                        $this->view->location('/profile/podt');
                    }else{
                        $this->view->redirect('/profile/podt');
                    }
                }
                break;
            case 3:
                if (!$this->isPodt){
                    if (!empty($_POST)){
                        $this->view->location('/prifile/login');
                    }else{
                        $this->view->redirect('/prifile/login');
                    }
                }
                if (!$this->ePodt){
                    if (!empty($_POST)){
                        $this->view->location('/prifile/podt');
                    }else{
                        $this->view->redirect('/prifile/podt');
                    }
                }
                if ($this->curUser['company']==''){
                    if (!empty($_POST)){
                        $this->view->location('/prifile');
                    }else{
                        $this->view->redirect('/prifile');
                    }
                }
                break;
        }
    }

    public function loadModel($name){
        $path = 'application\models\\'.ucfirst($name);
        if (class_exists($path)){
            return new $path;
        }
    }
    public function paramsModel(){
        $this->paramModel = $this->loadModel('param');
        $this->allParams = $this->paramModel->getParams();
        foreach ($this->allParams as $oneparam){
            $this->params[$oneparam['name']] = $oneparam['value'];
        }
    }

    public function iniUser(){
        $this->userModel = $this->loadModel('user');
    }
    public function getUserById($id){
        $userData = $this->userModel->getUserById($id);
        return $userData;
    }
    public function getUserByEmail($email){
        $userData = $this->userModel->getUserByEmail($email);
        return $userData;
    }
    public function userPodt($login,$pass){
        $isPodt = $this->userModel->userPodt($login,$pass);
        return $isPodt;
    }
    public function rdate($param, $time=0) {//возможно вынести в отдельную библиотеку с помагательными функциями
        if(intval($time)==0)$time=time();
        $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        if(strpos($param,'M')===false) return date($param, $time);
        else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
    }
}