<?php
namespace App\DataBase;

class Connection{

    protected $db;

    public function __construct(){
        $this->db = new \PDO("mysql:host=127.0.0.1;dbname=file_uploads",'root','');
    }

}