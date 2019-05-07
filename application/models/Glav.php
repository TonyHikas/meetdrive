<?php

namespace application\models;
use application\core\Model;

class Glav extends Model{
    public function getEventByAlias($alias){
        $onepar = [
            'alias'=>$alias,
        ];
        $result = $this->db->row('SELECT * FROM event WHERE alias = :alias', $onepar);
        if ($result != false){
            return $result[0];
        }else{
            return $result;
        }
    }
    public function getAllEvents($page){
        $onepar = [
            'time'=>time(),
        ];
        $resLim = $this->db->limitRow('SELECT * FROM event WHERE start_date > :time ORDER BY start_date ASC', $onepar, $page);
        return $resLim;
    }
    public function getUchast($event_id,$is_podt){
        $onepar = [
            'event_id'=>$event_id,
        ];
        if ($is_podt){
            $res = $this->db->Row('SELECT * FROM uchastie WHERE event_id  = :event_id AND podt = 1 ORDER BY date ASC', $onepar);
        }else{
            $res = $this->db->Row('SELECT * FROM uchastie WHERE event_id  = :event_id AND (podt != 1 OR podt = NULL)ORDER BY date ASC', $onepar);
        }
        if ($res != false){
            return $res;
        }else{
            return $res;
        }

    }
}