<?php

namespace App\Controller;


use App\Router\Router;

class BaseController{

    public function run(){

        $connectorPath = ROOT.'/app/Connection.php';
        $mapperPath = ROOT.'/app/DB.php';
        $routerPath = ROOT.'/app/Router.php';
        if(file_exists($mapperPath)){
            include_once $connectorPath;
        }
        if(file_exists($mapperPath)){
            include_once $mapperPath;
        }
        if(file_exists($routerPath)){
            include_once $routerPath;
            $router = new Router();
            $router->run();
        }

    }

    public function getModel($name){
        $modelPath = ROOT.'/models/'.$name.'.php';
        if(file_exists($modelPath)){
            include_once $modelPath;
            $model = "\\App\\Models\\$name";
            return new $model();
        }
    }

}