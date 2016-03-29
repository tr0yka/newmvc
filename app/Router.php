<?php
namespace App\Router;

use App\Controller;

class Router{

    public function run(){
        $uri = $this->getURL();
        $controller = 'Files';
        $method = 'list';
        $elements = explode('/',$uri);
        if(!empty($elements[0])){
            $controller = $elements[0];
        }else{

        }
        if(!empty($elements[1])){
            $method = $elements[1];
        }
        $controllerName = ucfirst($controller).'Controller';
        $actionName = $method.'Action';

        if(file_exists(ROOT.'/controllers/'.$controllerName.'.php')){
            include_once ROOT.'/controllers/'.$controllerName.'.php';
            $class = "\\App\\Controller\\$controllerName";
            $methods = get_class_methods($class);
            if(in_array($actionName,$methods)){
                $controller = new $class();
                $controller->$actionName();
            }else{
                http_response_code(404);
                echo 'Ошибка 404. Страница не найдена';
            }
        }else{
            http_response_code(404);
            echo 'Ошибка 404. Страница не найдена';
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