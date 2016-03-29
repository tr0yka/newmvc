<?php
namespace App\Config;

class Config{

    public $maxWidth = 300;
    public $maxheight = 300;
    public $maxSize = 20*1024*1024;
    public $acceptTypes = array('jpg','png','bmp','exe','doc','docx','xml','xmlx','pdf','zip','rar','7zip','txt');
    public $folder = '../uploads/';

}