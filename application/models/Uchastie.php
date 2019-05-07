<?php

namespace application\models;
use application\core\Model;

class Uchastie extends Model{

    public function checkUchastie($user_id, $event_id){
        $pars = [
            'user_id'=>$user_id,
            'event_id'=>$event_id,
        ];
        $res = $this->db->row('SELECT * FROM uchastie WHERE user_id = :user_id AND event_id = :event_id',$pars);
        if ($res!=false){
            return $res[0];
        }else{
            return false;
        }
    }
    public function newUchastie($user_id, $event_id, $avto_id, $start_date,$podt){
        $pars = [
            'user_id'=>$user_id,
            'event_id'=>$event_id,
            'avto_id'=>$avto_id,
            'date' =>time(),
            'start_date' => $start_date,
            'podt'=>$podt,
        ];
        $res = $this->db->query('INSERT INTO uchastie (user_id, event_id, avto_id, date, start_date, podt) values(:user_id, :event_id, :avto_id, :date, :start_date, :podt)',$pars);
    }
    public function newUchastieCode($user_id, $event_id, $avto_id, $start_date,$podt, $code){
        $pars = [
            'user_id'=>$user_id,
            'event_id'=>$event_id,
            'avto_id'=>$avto_id,
            'date' =>time(),
            'start_date' => $start_date,
            'podt'=>$podt,
            'code'=>$code,
        ];
        $res = $this->db->query('INSERT INTO uchastie (user_id, event_id, avto_id, date, start_date, podt, podt_key) values(:user_id, :event_id, :avto_id, :date, :start_date, :podt, :code)',$pars);
    }

    public function updateUchastie($user_id, $event_id, $avto_id, $type){
        $zero = 0;
        if (($type == 1)){
            $pars = [
                'user_id'=>$user_id,
                'event_id'=>$event_id,
                'avto_id'=>$avto_id,
                'date' =>time(),
                'podt'=>0,
            ];
            $this->db->query('UPDATE uchastie SET avto_id = :avto_id, date = :date, podt = :podt WHERE user_id = :user_id AND event_id = :event_id', $pars);
        }elseif(($type == 3) or ($type == 2)){
            $pars = [
                'user_id'=>$user_id,
                'event_id'=>$event_id,
                'avto_id'=>$avto_id,
                'date' =>time(),
            ];
            $this->db->query('UPDATE uchastie SET avto_id = :avto_id, date = :date WHERE user_id = :user_id AND event_id = :event_id', $pars);
        }


    }
    public function exitUchastie($user_id, $event_id, $code = false){
        $pars = [
            'user_id'=>$user_id,
            'event_id'=>$event_id,
        ];
        $res = $this->db->query('DELETE FROM uchastie WHERE user_id = :user_id AND event_id = :event_id',$pars);
        if ($code !=false){
            $pars2 = [
                'code'=>$code,
                'event_id'=>$event_id,
            ];
            $this->db->query('UPDATE codes SET count = count + 1 WHERE code = :code AND event_id = :event_id', $pars2);
        }
    }

    public function checkCode($code,$event_id){
        $pars = [
            'code'=>$code,
            'event_id'=>$event_id,
        ];
        $res = $this->db->row('SELECT * FROM codes WHERE event_id = :event_id AND code = :code',$pars);
        if (($res!=false) and ($res[0]['count']>0)){
            return $res[0];
        }else{
            return false;
        }
    }

    public function codeUse($code, $event_id){
        $pars = [
            'code'=>$code,
            'event_id'=>$event_id,
        ];
        $this->db->query('UPDATE codes SET count = count - 1 WHERE code = :code AND event_id = :event_id', $pars);
    }


}