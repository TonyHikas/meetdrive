<?php

namespace application\models;
use application\core\Model;

class Input extends Model{

    public function checkCar($brand, $model){
        $pars = [
            'brand'=>$brand,
        ];


        $res = $this->db->row('SELECT * FROM brands WHERE name = :brand',$pars);
        if ($res == false){return false;}
        $pars2 = [
            'model'=>$model,
            'brand_id'=>$res[0]['id'],
        ];
        $res2 = $this->db->row('SELECT * FROM models WHERE name = :model AND brand_id = :brand_id',$pars2);
        if ($res2!=false){
            return true;
        }else{
            return false;
        }
    }
    public function getCarBrands(){
        $res = $this->db->row('SELECT name FROM brands');
        return $res;
    }



}