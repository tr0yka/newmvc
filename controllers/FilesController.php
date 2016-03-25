<?php
namespace App\Controller;

class FilesController extends BaseController{

    public function listAction(){
        $fiels = $this->getModel('Files');
        $res = $fiels->fetchAll();
        print_r($res);
    }

}