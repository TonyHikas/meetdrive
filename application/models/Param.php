<?php

namespace application\models;
use application\core\Model;

class Param extends Model{
    public function getParams(){
        $result = $this->db->row('SELECT * FROM params');
        return $result;
    }
    public function getOneParam($one){
        $onepar = [
            'id'=>$one,
        ];
        $result = $this->db->row('SELECT * FROM params WHERE id = :id',$onepar);
        return $result;

    }
    public function editParam($id,$value){
        $params = [
            'id'=>$id,
            'value'=>$value,
        ];

        $this->db->query('UPDATE params SET value = :value WHERE id = :id', $params);

    }
}