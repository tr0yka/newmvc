<?php
namespace App;
use App\Controller\BaseController;
define(ROOT,__DIR__);


include_once ROOT.'/app/BaseController.php';

$base = new BaseController();
$base->run();