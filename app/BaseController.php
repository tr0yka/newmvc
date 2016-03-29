<?php

namespace App\Controller;

use App\Router\Router;
use App\View\View;

class BaseController{

    public $view;

    public function __construct(){
        $viewPath = ROOT.'/app/View.php';
        if(file_exists($viewPath)){
            include_once $viewPath;
            $this->view = new View();
        }
    }

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

    public function getConfig(){
        $configPath = ROOT.'/app/Config.php';
        if(file_exists($configPath)){
            include_once $configPath;
            $config = "\\App\\Config\\Config";
            return new $config();
        }
    }

}