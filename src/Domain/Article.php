<?php
namespace MicroCMS\Domain;

class Article
{
  
    
    protected $id,
              $title,
              $content;
    
    public function __construct() {
        
    }
    
    //SETTERS
    public function setId($id)
    {
        $this->id = (int)$id;
    }
    
    public function setTitle($title) 
    {
        if(isset($title)){
            $this->title = $title;
        } else {
            throw new Exception("titre invalide");
        }
            
    }
    
    public function setContent($content) 
    {
        if(isset($content)){
            $this->content = $content;
        } else {
            throw new Exception("contenu invalide");
        }
            
    }
    
    //GETTERS
    public function getId() 
    {
        return $this->id;
    }
    
    public function getTitle() 
    {
        return $this->title;
    }
    
    public function getContent() 
    {
        return $this->content;
    }
}

