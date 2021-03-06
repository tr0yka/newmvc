<?php
namespace App\Controller;

use App\Config\Config;

class FilesController extends BaseController{

    private $errors = [];
    private $config;

    public function __construct(){
        parent::__construct();
        $this->config = $this->getConfig();
    }

    public function listAction(){

        $files = $this->getModel('Files');
        $res = $files->fetchAll(['added' => 'DESC']);
        $this->view->assign('title','Files Upload');
        $this->view->assign('files',$res);
        echo $this->view->parse('base');

    }

    public function downloadAction(){
        if(isset($_GET['file']) && is_numeric($_GET['file']) && !empty($_GET['file'])){
            $id = $_GET['file'];
            $file = $this->getModel('Files');
            $res = $file->find($id);
            $fileName = $res[0]->getOriginalName();
            $fname = $res[0]->getFileName();
            $filePath = $this->config->folder.$fname;
            $fileSize = filesize($filePath);
            $this->download($fileName,$filePath,$fileSize);
        }
    }

    public function uploadAction(){
        $id = $this->upload();
        $data = array();
        if($id!=false){
            $data['errors'] = '';
            $file = $this->getModel('Files');
            $res = $file->find($id);
            $f = $res[0];
            $data['file'] = array(
                'id' => $f->getId(),
                'originalName' => $f->getOriginalName(),
                'fileSize' => $f->getFileSize(),
                'fileType' => $f->getFileType(),
                'description' => $f->getDescription(),
                'added' => $f->getAdded()
            );
        }else{
            foreach($this->errors as $error){
               $data['errors'][] = $error;
            }
            $data['file'] = '';
        }
        echo json_encode($data);
    }

    public function filterAction(){
        if(isset($_GET['filter'])){
            $files = $this->getModel('Files');
            $filter = htmlspecialchars($_GET['filter']);
            $res = $files->filter($filter);
            $this->view->assign('files',$res);
            echo $this->view->parse('filter');
        }
    }

    private function upload(){
        if(isset($_POST['fileUpload'])){

            if($_FILES['userfile']['size']==0){
                return false;
            }

            $fileIndexName = $this->generateName();
            $upload_file = $this->config->folder.$fileIndexName;

            $fileType = explode('.',$_FILES['userfile']['name']);
            $fileType = $fileType[count($fileType)-1];

            if($this->checkFileAction($_FILES['userfile']['tmp_name'],$fileType,$this->config)){
                if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_file)){

                    $date = new \DateTime();
                    $now = $date->format('Y-m-d H:i:s');
                    $file = $this->getModel('Files');
                    $file->setOriginalName($_FILES['userfile']['name']);
                    $file->setFileName($fileIndexName);
                    $file->setFileSize(filesize($upload_file));
                    $file->setFileType($fileType);
                    $file->setAdded($now);
                    $file->setComment(htmlspecialchars($_POST['comment']));
                    $file->setDescription(htmlspecialchars($_POST['description']));
                    $file->save();
                    $id = $file->getId();
                    if($id == null){
                        unlink($upload_file);
                        $this->errors['error_inserting'] = 'Ошибка записи в базу данных';
                        return false;
                    }
                }else{
                    $this->errors['error_move'] = 'Ошибка копирования файла';
                    return false;
                }

            }else{
                return false;
            }

            return $id;

        }

    }

    private function download($name,$path,$size){
        if ($_SERVER["HTTP_RANGE"]) {
            $range = $_SERVER["HTTP_RANGE"];
            $range = str_replace('bytes=','', $range);
            list($range_start,$range_end) = explode("-", $range);
            header('HTTP/1.1 206 Partial Content');
            header('Accept-Ranges: bytes');
            header('Content-Range: bytes '.intval($range_start).'-'.intval($range_end).'/'.$size);
        }
        else {
            $range_start=0;
            $range_end=$size-1;
            header('HTTP/1.1 200 Ok');
        }
        header('Content-Length: '.($range_end-$range_start+1));
        header('Content-Type: application/octet-stream');
        header('Content-disposition: attachment; filename="'.$name.'"');
        header("Last-Modified: ".date('r',filemtime($path)));
        $fh=fopen($path,'rb');
        fseek($fh,$range_start);
        $position=$range_start;
        $bufsize= 512;
        while ($buffer=fread($fh,$bufsize)) {
            if ($position+$bufsize>$range_end){
                $buffer=substr($buffer,0,$range_end-$position);
            }
            $position+=$bufsize;
            print $buffer;
            fflush($fh);
        }
        fclose($fh);

    }

    private function checkFileAction($path,$type,Config $config){
        $imageInfo = getimagesize($path);
        if(!in_array($type,$config->acceptTypes)){
            $this->errors['type'] = 'Неразрешенный тип файла';
            return false;
        }
        if(($type == 'jpg' || $type == 'png' || $type == 'bmp') && $imageInfo = false ){
            $this->errors['error_image'] = 'Файл не является изображением или поврежден';
            return false;
        }
        if($config->maxSize<filesize($path)){
            $this->errors['size'] = 'Файл больше допустимого размера';
            return false;
        }
        if(($imageInfo[0]>$config->maxWidth || $imageInfo[1]>$config->maxheight) && $imageInfo != false ){
            $this->errors['maxWH'] = 'Высота или ширина не соответствуют разрешенным';
            return false;
        }
        return true;
    }

    private function generateName(){
        $name = '';
        for($i=0;$i<20;$i++){
            $name  .= rand(0,9);
        }
        return md5($name);
    }

}