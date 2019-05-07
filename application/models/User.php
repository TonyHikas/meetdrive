<?php

namespace application\models;
use application\core\Model;

class User extends Model{
    public function getUserById($par){
        $onepar = [
            'id'=>$par,
        ];
        $result = $this->db->row('SELECT * FROM user WHERE id = :id', $onepar);
        if ($result != false){
            return $result[0];
        }else{
            return $result;
        }
    }
    public function getUserByEmail($par){
        $onepar = [
            'email'=>$par,
        ];
        $result = $this->db->row('SELECT * FROM user WHERE email = :email', $onepar);
        if ($result != false){
            return $result[0];
        }else{
            return $result;
        }

    }
    public function userPodt($login,$pass){
        $pars = [
            'email' => $login,
            'pass'  => $pass,
        ];
        $result = $this->db->column('SELECT id FROM user WHERE email = :email and pass = :pass', $pars);
        if ($result ==false){
            return false;
        }else{
            return true;
        }

    }
    public function registerUser($name,$email,$pass,$tel){
        //INSERT INTO users (login, pass) values('TestUser', '123456')
        $pod_email = md5(rand(9999,99999));
        $pars = [
            'name'  => $name,
            'email' => $email,
            'pass'  => md5($pass),
            'tel'   => $tel,
            'reg_date'=>time(),
            'pod_email'=>$pod_email,
        ];
        $res = $this->db->query('INSERT INTO user (name, email, pod_email, tel, pass, reg_date) values(:name, :email, :pod_email, :tel, :pass, :reg_date)',$pars);
        $userRed = $this->getUserByEmail($email);

          $to = $email;
          $subject = "meetDrive.ru - Подтверждение email";
          $message = 'Пройдите по ссылке для подтверждения email : http://driftandchill.ru/profile/confirm/'.$userRed['id'].'/'.$pod_email;
          mail ($to, $subject, $message);

        return $res;
    }
    public function emailPodt($id){
        $params = [
            'id'=>$id,
            'pod_email' =>1,
        ];

        $this->db->query('UPDATE user SET pod_email = :pod_email WHERE id = :id', $params);

    }
    public function emailChange($id,$email){
        $pod_email = md5(rand(9999,99999));
        $params = [
            'id'=>$id,
            'email'=>$email,
            'pod_email' =>$pod_email,
        ];

        $this->db->query('UPDATE user SET email= :email, pod_email = :pod_email WHERE id = :id', $params);
        $to = $email;
        $subject = "meetDrive.ru - Подтверждение email";
        $message = 'Пройдите по ссылке для подтверждения email : http://driftandchill.ru/profile/confirm/'.$id.'/'.$pod_email;
        mail ($to, $subject, $message);
    }
    public function passChange($id,$pass){
        $params = [
            'id'=>$id,
            'pass'=>md5($pass),
        ];
        $this->db->query('UPDATE user SET pass= :pass WHERE id = :id', $params);
    }
    public function dataChange($id,$name,$city,$tel){
        $params = [
            'id'=>$id,
            'name'=>$name,
            'city'=>$city,
            'tel'=>$tel,
        ];
        $this->db->query('UPDATE user SET name = :name, city = :city,tel = :tel WHERE id = :id', $params);
    }
    public function podpassChange($id,$pod_pass){
        $params = [
            'id'=>$id,
            'pod_pass'=>$pod_pass,
            'pod_time'=>(time()+1800),
        ];
        $this->db->query('UPDATE user SET pod_pass = :pod_pass, pod_time = :pod_time WHERE id = :id', $params);
    }

}