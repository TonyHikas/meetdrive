<?php
namespace application\lib;
use PDO;
class Db{
    protected $db;

    public function __construct() {
        $config = require 'application/config/db.php';
        $charset="utf-8";
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                if (is_int($val)) {
                    $type = PDO::PARAM_INT;
                } else {
                    $type = PDO::PARAM_STR;
                }
                $stmt->bindValue(':'.$key, $val, $type);
            }
        }
        $stmt->execute();
        return $stmt;
    }
    public function row($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function column($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
    public function limitRow($sql, $params, $page){//только запросы начинающиеся с select *
        $sql = mb_substr($sql, mb_strpos($sql, ' '));
        $sql = substr($sql, 2);
        $lim1 = ($page - 1)*20;
        $lim2 = $page*20;
        $count = $this->row('SELECT COUNT(*) '.$sql, $params);
        $count = $count[0]['COUNT(*)'];
        if (ceil($count/20)>=$page and $page > 0){
            $params['lim1']=$lim1;
            $params['lim2']=$lim2;
            $result = $this->row('SELECT * '.$sql.' LIMIT :lim1,:lim2', $params);
        }else{
            return false;
        }
        if ($result != false){
            $ret = [
                'rows' => $result,
                'count'  => $count,
            ];
            return $ret;
        }else{
            return false;
        }
    }
}