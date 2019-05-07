<?php
namespace application\controllers;
use application\core\Controller;

class InputController extends Controller {

    public function getCarBrandsAction(){
        $brands = $this->model->getCarBrands();
        $ready_brands = [];
        foreach ($brands as $brand){
            array_push($ready_brands,$brand['name']);
        }
        echo ( json_encode($ready_brands, JSON_UNESCAPED_UNICODE));

    }


}