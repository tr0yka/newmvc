<?php
namespace App\DataBase;

class DB extends Connection{

    public function fetchAll(array $orderBy = null){
        if($orderBy!=null){
            $str = 'ORDER BY';
            foreach($orderBy as $key => $value){
                $str .= " {$key} $value";
            }
            $sql = "SELECT * FROM {$this->table} ".$str;
        }else{
            $sql = "SELECT * FROM {$this->table}";
        }

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

    public function find($id){
        $sql = 'SELECT * FROM '.$this->table.' WHERE id='.$id;
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

    public function findBy(array $options,$andor=null){
        if($options != null){
            $sql = 'SELECT * FROM '.$this->table.' WHERE ';
            $str = '';
            foreach ($options as $field => $value) {
                if($andor==null and count($options)==1){
                    $str .= ' '.$field.'="'.$value.'"';

                }else{
                    $str .= ' '.$field.'="'.$value.'" '.strtoupper($andor);
                }

            }
            $sql .= substr($str,0,-strlen($andor)-1);
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
        }else{
            throw new \Exception('РќРµ СѓРєР°Р·Р°РЅС‹ РєСЂРёС‚РµСЂРёРё РїРѕРёСЃРєР°');
        }
    }

    public function filter($filter=null){
        if($filter!=null){
            $sql = "SELECT * FROM ".$this->table." WHERE originalName LIKE '%{$filter}%'";
        }else{
            $query = "SELECT * FROM ".$this->table." ORDER BY added DESC";
        }
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

    public function save(){
        if($this->getId() != null){
            $this->update();
        }else{
            $this->insert();
        }
    }

    public function insert(){
        $sql = 'INSERT INTO '.$this->table.' ';
        $sql .= '('.implode(',',$this->cols).')VALUES("';
        $vals = array();
        foreach($this->cols as $col){
            $method = 'get'.ucfirst($col);
            $vals[] = $this->$method();
        }
        $sql.= implode('","',$vals).'")';
        $pr = $this->db->prepare($sql);
        $pr->execute();
        $this->setId($this->db->lastInsertId());
    }

    public function update(){
        $sql = "UPDATE {$this->table} SET";
        $vals = array();
        foreach($this->cols as $col){
            $method = 'get'.ucfirst($col);
            $vals[] = $col."'".$this->$method()."'";
        }
        $sql .= implode(',',$vals);
        $sql .= " WHERE id=".$this->getId();
        $pr = $this->db->prepare($sql);
        $pr->execute();
    }

    public function delete(){
        if($this->getId() != null){
            $sql = 'DELETE FROM '.$this->table.' WHERE id='.$this->getId();
            $pr = $this->db->prepare($sql);
            if($pr->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            throw new \Exception('РќРµРѕР±С…РѕРґРёРјРѕ СѓРєР°Р·Р°С‚СЊ ID Р·Р°РїРёСЃРё РґР»СЏ СѓРґР°Р»РµРЅРёСЏ');
        }
    }

}