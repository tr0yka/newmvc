<?php
namespace App\Router;

use App\Controller;

class Router{

    public function run(){
        $uri = $this->getURL();
        $routing = require_once ROOT.'/app/Routes.php';
        foreach ($routing as $pattern => $path) {
            if(preg_match("~$pattern~",$uri)){
                $segments = explode('/',$path);
                $controllerName = ucfirst(array_shift($segments)).'Controller';
                $actionName = array_shift($segments).'Action';
                echo $controllerName;
                if(file_exists(ROOT.'/controllers/'.$controllerName.'.php')){
                    include_once ROOT.'/controllers/'.$controllerName.'.php';
                }else{
                    throw new \Exception('Отсутствует файл контроллера');
                }
                $class = "\\App\\Controller\\$controllerName";
                $controller = new $class();
                $res = $controller->$actionName();
                if($res != null){
                    break;
                }

            }
        }
    }

    private function getURL(){
        $uri = $_SERVER['REQUEST_URI'];
        if(!empty($uri)){
            $uri = trim($uri,'/');
        }
        return $uri;
    }

}