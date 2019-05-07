<?php

namespace application\models;
use application\core\Model;

class Event extends Model{
    public function translit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "_", $s); // заменяем пробелы знаком минус
        $onepar = [
            'alias'=>$s,
        ];
        $result = $this->db->row('SELECT * FROM event WHERE alias = :alias', $onepar);
        if ($result != false){
            return false;
        }else{
            return $s;
        }
         // возвращаем результат
    }
    public function getUserEvents($id,$isActive,$page){
        $onepar = [
            'creator_id'=>$id,
            'date'=>time(),
        ];
        if ($isActive){
            $resLim = $this->db->limitRow('SELECT * FROM event WHERE creator_id  = :creator_id AND start_date > :date ORDER BY start_date ASC', $onepar, $page);
            return $resLim;
        }else{
            $resLim = $this->db->limitRow('SELECT * FROM event WHERE creator_id  = :creator_id AND start_date < :date ORDER BY start_date ASC', $onepar, $page);
            return $resLim;
        }

    }
    public function getOneEvent($eventId,$userID){
        $onepar = [
            'id'=>$eventId,
            'creator_id'=>$userID,
        ];
        $result = $this->db->row('SELECT * FROM event WHERE creator_id = :creator_id and id = :id', $onepar);
        if ($result != false){
            return $result[0];
        }else{
            return $result;
        }
    }
    public function getEvent($eventId){
        $onepar = [
            'id'=>$eventId,
        ];
        $result = $this->db->row('SELECT * FROM event WHERE id = :id', $onepar);
        if ($result != false){
            return $result[0];
        }else{
            return $result;
        }
    }
    public function editEvent($id, $nazv, $opis, $start_date, $category, $transport_type, $city, $event_type, $price, $adress){
        $params = [
            'id'=>$id,
            'nazv' =>$nazv,
            'opis' =>$opis,
            'start_date' =>$start_date,
            'category' =>$category,
            'transport_type' =>$transport_type,
            'city' =>$city,
            'event_type' =>$event_type,
            'price' =>$price,
            'edit_date' =>time(),
            'adress'=>$adress,
        ];

        $this->db->query('UPDATE event SET nazv = :nazv, opis = :opis, start_date = :start_date, category = :category, transport_type = :transport_type, city = :city, event_type = :event_type, price = :price, edit_date = :edit_date, adress = :adress WHERE id = :id', $params);
    }
    public function updateStartUchastie($event_id, $new_start_date){
        $params = [
            'event_id'=>$event_id,
            'start_date' =>$new_start_date,
        ];
        $this->db->query('UPDATE uchastie SET start_date = :start_date WHERE event_id = :event_id', $params);
    }
    public function addEvent($creator_id,$nazv, $opis, $start_date, $category, $transport_type, $city, $event_type, $price, $adress){
        $tran = false;
        $tran = $this->translit($nazv);
        while ($tran==false){
            $tran = $this->translit($nazv.'_'.rand(time(),time()+10));
        }
        $pars = [
            'creator_id'=>$creator_id,
            'alias'=>$tran,
            'nazv' =>$nazv,
            'opis' =>$opis,
            'start_date' =>$start_date,
            'category' =>$category,
            'transport_type' =>$transport_type,
            'city' =>$city,
            'event_type' =>$event_type,
            'price' =>$price,
            'reg_date' =>time(),
            'adress'=>$adress,
        ];
        $res = $this->db->query('INSERT INTO event (creator_id, alias, nazv, opis, start_date, category, transport_type, city, event_type, price, reg_date, adress) values(:creator_id, :alias, :nazv, :opis, :start_date, :category, :transport_type, :city, :event_type, :price, :reg_date, :adress)',$pars);
    }
    public function deleteEvent($id,$event){
        $pars = [
            'last_id'=>$event['id'],
            'creator_id'=>$event['creator_id'],
            'alias'=>$event['alias'],
            'nazv' =>$event['nazv'],
            'opis' =>$event['opis'],
            'start_date' =>$event['start_date'],
            'category' =>$event['category'],
            'transport_type' =>$event['transport_type'],
            'city' =>$event['city'],
            'event_type' =>$event['event_type'],
            'price' =>$event['price'],
            'reg_date' =>$event['reg_date'],
            'edit_date'=>$event['edit_date'],
            'adress'=>$event['adress'],
            'limit_of_uch'=>$event['limit_of_uch'],
            'type'=>$event['type'],
            'imgs'=>$event['imgs'],
        ];
        $res = $this->db->query('INSERT INTO delete_event (last_id, creator_id, alias, nazv, opis, start_date, category, transport_type, city, event_type, price, reg_date, edit_date, adress, limit_of_uch, type, imgs) values(:last_id, :creator_id, :alias, :nazv, :opis, :start_date, :category, :transport_type, :city, :event_type, :price, :reg_date, :edit_date, :adress, :limit_of_uch, :type, :imgs)',$pars);
        $pars = [
            'id'=> $id,
        ];
        $res = $this->db->query('DELETE FROM event WHERE id = :id',$pars);

    }

    public function regCompany($id,$company,$link,$company_opis){
        $params = [
            'id'=>$id,
            'company'=>$company,
            'company_link'=>$link,
            'company_opis'=>$company_opis,
            'company_reg_date' =>time(),
        ];

        $this->db->query('UPDATE user SET company = :company, company_link = :company_link, company_opis = :company_opis, company_reg_date = :company_reg_date WHERE id = :id', $params);
    }
    public function updateCompany($id,$company,$link,$company_opis){
        $params = [
            'id'=>$id,
            'company'=>$company,
            'company_link'=>$link,
            'company_opis'=>$company_opis,
            'company_edit_date' =>time(),
        ];

        $this->db->query('UPDATE user SET company = :company, company_link = :company_link, company_opis = :company_opis, company_edit_date = :company_edit_date WHERE id = :id', $params);
    }
    public function getActiveOrArchive($user_id, $isActive, $page){
        $onepar = [
            'user_id'=>$user_id,
            'date'=>time(),
        ];
        if ($isActive){
            $resLim = $this->db->limitRow('SELECT * FROM uchastie WHERE user_id  = :user_id AND start_date > :date ORDER BY start_date ASC', $onepar, $page);
        }else{
            $resLim = $this->db->limitRow('SELECT * FROM uchastie WHERE user_id  = :user_id AND start_date < :date ORDER BY start_date ASC', $onepar, $page);
        }
        if ($resLim['rows'] != false){
            $events = [];
            foreach ($resLim['rows'] as $res){
                $event = $this->getEvent($res['event_id']);
                    if ($event!=false) {
                        array_push($events,$event);
                    }
            }
            $ret = [
              'events' => $events,
              'count'  => $resLim['count'],
            ];
            return $ret;
        }else{
            return false;
        }
    }


}