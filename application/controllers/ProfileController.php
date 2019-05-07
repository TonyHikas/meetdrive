<?php
namespace application\controllers;
use application\core\Controller;

class ProfileController extends Controller {


    public function mainAction(){
        $this->accessLevel(1);
            $vars = [
                'params'=>$this->params,
                'user'=>$this->curUser,
            ];
            $this->view->render('Профиль',$vars);

    }
    public function podtAction(){
        $this->accessLevel(1);
        if (!empty($_POST) and $_POST['confirm']=='yes'){
            $to = $this->curUser['email'];
            $subject = "meeDrive.ru - Подтверждение email";
            $message = 'Пройдите по ссылке для подтверждения email : http://driftandchill.ru/profile/confirm/'.$this->curUser['id'].'/'.$this->curUser['pod_email'];
            mail ($to, $subject, $message);
            $this->view->message('error','Письмо отправленно');
        }
        $this->view->render('Подтвердите email');
    }

    public function loginAction(){
        if (!empty($_POST)){
            $first = $this->getUserByEmail($_POST['login']);
            if ($first!=false){
                if ($first['pass']==md5($_POST['password'])){
                    $_SESSION['login'] = $_POST['login'];
                    $_SESSION['pass'] = md5($_POST['password']);
                    $_SESSION['id']=$first['id'];
                    $this->view->location('/profile');

                }
            }
            $this->view->message('error','Неверные данные');
        }
        if ($this->isPodt){
            $this->view->redirect('/profile');
        }else{
            $vars = [
                'params'=>$this->params,
            ];
            $this->view->render('Вход',$vars);
        }
    }

    public function registerAction(){
        if (!empty($_POST)){
            if (trim($_POST['name'])==''){
                $this->view->message('error','Заполните имя');
            }
            if (trim($_POST['login'])==''){
                $this->view->message('error','Заполните email');
            }
            if (trim($_POST['password'])==''){
                $this->view->message('error','Заполните пароль');
            }
            if (trim($_POST['password2'])==''){
                $this->view->message('error','Повторите пароль');
            }
            //добавить код на проверку допустимых символов внутри пароля
            if ($_POST['password']!=$_POST['password2']){
                $this->view->message('error','Пароли не совпадают');
            }
            $first = $this->getUserByEmail($_POST['login']);
            if ($first!=false){
                $this->view->message('error','Такой email уже зарегистрирован');
            }else{
                //регистрация
                $res = $this->userModel->registerUser(trim($_POST['name']),trim($_POST['login']),trim($_POST['password']),trim($_POST['tel']));
                $_SESSION['login'] = $_POST['login'];
                $_SESSION['pass'] = md5($_POST['password']);
                $this->view->location('/profile');
            }

        }
        if ($this->isPodt){
            $this->view->redirect('/profile');
        }else{
            $vars = [
                'params'=>$this->params,
            ];
            $this->view->render('Регистрация',$vars);
        }
    }

    public function logoutAction(){
        $_SESSION['login']='';
        $_SESSION['pass'] = '';
        $_SESSION['id'] = '';
        $this->view->redirect('/profile/login');
    }
    public function confirmAction(){
        $us = $this->userModel->getUserById($this->route['id']);
        if ($us!=false){
            if ($us['pod_email']==1){
                echo 'Вы уже подтвердили свой email';
            }else{
                if ($us['pod_email']==$this->route['key']){
                    $this->userModel->emailPodt($this->route['id']);
                    $this->view->redirect('/profile');
                }else{
                    echo 'Неверный ключ или срок активации закончился';
                }
            }
        } else{
            echo 'Ошибка, ссылка не действительная';
        }
    }
    public function emailchangeAction(){
        $this->accessLevel(1);
        if (!empty($_POST)){
            if ($_POST['email']==$this->curUser['email']){
                $this->view->message('error','Email совпадает с текущим');
            }
            if (trim($_POST['email'])==''){
                $this->view->message('error','Заполните новый email');
            }
            if ($this->userModel->getUserByEmail($_POST['email'])!=false){
                $this->view->message('error','Такой email уже зарегистрирован');
            }
            //смена email и замена подтверждения
            $this->userModel->emailChange($_SESSION['id'],trim($_POST['email']));
            $_SESSION['login']=trim($_POST['email']);
            $this->view->location('/profile/');
        }else{
            $vars = [
                'params'=>$this->params,
                'email'=>$this->curUser['email'],
            ];
            $this->view->render('Редактировать email',$vars);
        }
    }
    public function passchangeAction(){
        $this->accessLevel(1);
        if (!empty($_POST)){
            if (trim($_POST['pass1'])!=trim($_POST['pass2'])){
                $this->view->message('error','Пароли не совпадают');
            }
            if (trim($_POST['pass1'])=='' and trim($_POST['pass1'])==''){
                $this->view->message('error','Заполните новый пароль');
            }
            if (md5($_POST['lastpass'])!=$this->curUser['pass']){
                $this->view->message('error','Неверный пароль (старый)');
            }
            //смена email и замена подтверждения
            $this->userModel->passChange($_SESSION['id'],trim($_POST['pass1']));
            $_SESSION['pass']=md5(trim($_POST['pass1']));
            $this->view->location('/profile/');
        }else{
            $vars = [
                'params'=>$this->params,
            ];
            $this->view->render('Редактировать email',$vars);
        }
    }
    public function datachangeAction(){
        $this->accessLevel(1);
        if (!empty($_POST)){
            if (trim($_POST['name'])==''){
                $this->view->message('error','Заполните имя');
            }
            $this->userModel->dataChange($_SESSION['id'],trim($_POST['name']),trim($_POST['city']),trim($_POST['tel']));
            $this->view->location('/profile/');
        }else{
            $vars = [
                'params'=>$this->params,
                'name'=>$this->curUser['name'],
                'city'=>$this->curUser['city'],
                'tel'=>$this->curUser['tel'],
            ];
            $this->view->render('Редактировать email',$vars);
        }
    }
    public function restoreAction(){
        if (!empty($_POST)){
            if (trim($_POST['email'])==''){
                $this->view->message('error','Заполните email');
            }
            $user = $this->getUserByEmail($_POST['email']);
            if ($user==false){
                $this->view->message('error','Такой email не найден');
            }
            if (($user['pod_time']-1800+60)>time()){
                $this->view->message('error','До повторной попытки отправки пароля '.(($user['pod_time']-1800+60)-time()).' секунд');
            }
            $key = (rand(1000,9999));
            $this->userModel->podpassChange($user['id'],$key);
            $to = trim($_POST['email']);
            $subject = "meetDrive.ru - Восстановить пароль";
            $message = 'Ваш ключ : '.$key;
            mail ($to, $subject, $message);
            $_SESSION['restore_email'] = trim($_POST['email']);
            $this->view->location('/profile/restorekey');
        }else{
            $this->view->render('Восстановить пароль');
        }
    }
    public function restorekeyAction(){
        if (!empty($_POST)){
            if (trim($_POST['key'])==''){
                $this->view->message('error','Заполните ключ');
            }
            if (trim($_POST['pass'])==''){
                $this->view->message('error','Заполните новый пароль');
            }
            $user = $this->getUserByEmail($_SESSION['restore_email']);
            if ($user==false){
                $this->view->message('error','Такой email не найден');
            }
            if ($user['pod_time']<time()){
                $this->view->message('error','Время действия ключа истекло');
            }
            if ($_POST['key']!=$user['pod_pass']){
                $this->view->message('error','Неверный ключ');
            }
            $this->userModel->passChange($user['id'],trim($_POST['pass']));
            $this->userModel->podpassChange($user['id'],md5(rand(9999,99999)));
            $this->view->location('/profile/login');

        }else{
            $vars = [
                'params'=>$this->params,
                'email'=>$_SESSION['restore_email'],
            ];
            $this->view->render('Восстановить пароль',$vars);
        }
    }




}