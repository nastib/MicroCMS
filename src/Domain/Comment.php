<?php

namespace MicroCMS\Domain;

Class Comment
{

    
    protected $id,
              $author,
              $content,
              $article;
    
    //SETTERS & GETTERS  

    public function setId($id){
          $this->id = $id;
      }
       
    public function getId(){
          return $this->id;
      }
        
    public function setAuthor(User $author){
          $this->author = $author;
      }
    public function getAuthor(){
          return $this->author;
      }
  
    public function setContent($content){
          $this->content = $content;
      }
    public function getContent(){
          return $this->content;
      }
     
    public function setArticle(Article $article){
          $this->article = $article;
      }
      
    public function getArticle(){
          return $this->article;
      }
      
}
