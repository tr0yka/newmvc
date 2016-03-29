<?php
namespace App\View;

class View{

    private $vars = array();
    private $tpldir = '/views/';
    private $content_type = '';

    public function __get( $name ){
        if( isset($this->vars[$name]) )
            return $this->vars[$name];
    }
    public function __set( $name,$value ){
        $this->vars[$name] = $value;
    }
    private function safe( $file ){
        if( file_exists($file) ){
            return file_get_contents($file);
        }else{
            throw new \Exception('Файл '.$file.' не найден ');
        }
    }
    private function exec($file) {
        eval('?>'.$this->safe( ROOT.$this->tpldir.$file.'.php') );
    }

    public function assign( $var, $val='' ) {
        if( is_scalar($var) )
            $this->vars[$var] = $val;
        else
            $this->vars = array_merge($this->vars,$var);
    }
    public function parse( $file,$vars = array() ) {
        ob_start();
        $this->show( $file,$vars );
        return ob_get_clean();
    }
    public function read( $file ){
        return $this->safe( ROOT.$this->tpldir.$file.'.php' );
    }

    public function show( $file,$vars = array() ) {
        $this->assign($vars);
        extract($this->vars);
        $this->exec( $file );
    }
    function setContentType( $type ){
        if( in_array(strtolower($type),array('page','json','html')) )
            $this->content_type = strtolower($type);
    }
    function getContentType( ){
        return $this->content_type;
    }

}