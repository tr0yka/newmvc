<?php
namespace App\Controller;

class FilesController extends BaseController{

    public function listAction(){
        //$fiels = $this->getModel('Files');
        //$res = $fiels->fetchAll();
        $this->view->assign('title','test');
        $this->view->parse('base.html');

    }

}