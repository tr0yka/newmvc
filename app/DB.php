<?php
namespace App\DataBase;

class DB extends Connection{

    public function fetchAll(){
        $sql = "SELECT * FROM {$this->table}";
        $pr = $this->db->prepare($sql);
        $pr->execute();
        $res = $pr->fetchAll();
        $records = array();
        foreach($res as $file){
            $tmp = new $this();
            $tmp->setOptions($file);
            $records[] = $tmp;
        }
        return $records;
    }

    public function setOptions($options){
        $methods = get_class_methods($this);
        foreach($options as $key => $value){
            $method = 'set'.ucfirst($key);
            if(in_array($method,$methods)){
                $this->$method($value);
            }
        }
    }

    //public function

}