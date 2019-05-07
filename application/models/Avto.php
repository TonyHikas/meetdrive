<?php

namespace application\models;
use application\core\Model;

class Avto extends Model{
    public function getUserAvtos($id){
        $onepar = [
            'owner_id'=>$id,
        ];
        $result = $this->db->row('SELECT * FROM avto WHERE owner_id = :owner_id', $onepar);
            return $result;

    }
    public function getUserAvtosPage($id,$page){
        $onepar = [
            'owner_id'=>$id,
        ];
        $result = $this->db->limitRow('SELECT * FROM avto WHERE owner_id = :owner_id', $onepar, $page);
        return $result;
    }
    public function getOneAvto($avtoId,$userID){
        $onepar = [
            'id'=>$avtoId,
            'owner_id'=>$userID,
        ];
        $result = $this->db->row('SELECT * FROM avto WHERE owner_id = :owner_id and id = :id', $onepar);
        if ($result != false){
            return $result[0];
        }else{
            return $result;
        }
    }
    public function editAvto($id,$brand,$model,$type,$opis){
        $params = [
            'id'=>$id,
            'brand' =>$brand,
            'model' =>$model,
            'type' =>$type,
            'opis' =>$opis,
            'edit_date' =>time(),
        ];

        $this->db->query('UPDATE avto SET brand = :brand, model = :model, type = :type, opis = :opis, edit_date = :edit_date WHERE id = :id', $params);
    }
    public function addAvto($owner_id,$brand,$model,$type,$opis){
        $pars = [
            'owner_id'=> $owner_id,
            'brand'  => $brand,
            'model' => $model,
            'type'  => $type,
            'opis'   => $opis,
            'reg_date'=>time(),
        ];
        $res = $this->db->query('INSERT INTO avto (owner_id, brand, model, type, opis, reg_date) values(:owner_id, :brand, :model, :type, :opis, :reg_date)',$pars);
    }
    public function deleteAvto($id,$avto){
        $pars = [
            'last_id'=>$avto['id'],
            'owner_id'=> $avto['owner_id'],
            'brand'  => $avto['brand'],
            'model' => $avto['model'],
            'type'  => $avto['type'],
            'opis'   => $avto['opis'],
            'reg_date'=>$avto['reg_date'],
            'edit_date'=>$avto['edit_date'],
        ];
        $res = $this->db->query('INSERT INTO delete_avto (last_id, owner_id, brand, model, type, opis, reg_date, edit_date) values(:last_id, :owner_id, :brand, :model, :type, :opis, :reg_date, :edit_date)',$pars);
        $pars = [
            'id'=> $id,
        ];
        $res = $this->db->query('DELETE FROM avto WHERE id = :id',$pars);

    }
}