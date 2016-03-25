<?php
namespace App\View;

class View{

    public $data = '1231231';

    public function render($templates, $data = null)
    {
        if(is_array($data)) {

            extract($data);
        }
        foreach($templates as $template){
            include_once 'views/'.$template.'.html.php';
        }
    }

    public function layer($name){
        include_once 'views/'.$name;
    }

}