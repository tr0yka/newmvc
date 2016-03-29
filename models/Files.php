<?php
namespace App\Models;

use App\DataBase\DB;

class Files extends DB{
    protected $table = 'files_info';
    protected $cols = ['fileName','originalName','fileType','fileSize','comment','description','added'];
    private $id;
    private $fileName;
    private $originalName;
    private $fileType;
    private $fileSize;
    private $comment;
    private $description;
    private $added;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }/**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }/**
     * @return mixed
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }/**
     * @param mixed $originalName
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    }/**
     * @return mixed
     */
    public function getFileType()
    {
        return $this->fileType;
    }/**
     * @param mixed $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }/**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }/**
     * @param mixed $fileSize
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }/**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }/**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }/**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }/**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * @return mixed
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @param mixed $added
     */
    public function setAdded($added)
    {
        $this->added = $added;
    }

}