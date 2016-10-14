<?php

namespace MicroCMS\Manager;

use MicroCMS\Domain\Article;

class ArticlesManager extends Manager
{
    //Retourne la liste de tous les articles
    public function findAll() {
      $req = 'SELECT * FROM t_article ORDER BY art_id DESC';
      $result = $this->getDb()->fetchAll($req);
      
      // Convert query result to an array of domain object
      $articles = [];
      foreach ($result as $row)
      {
          $articleId =  $row['art_id'];
          $articles[$articleId] = $this->buildDomainObject($row);
      }
      return $articles;
    }
    
    //Recherche un article à partir de son id
    public function find($id){
        $sql = "SELECT * FROM t_article WHERE art_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if($row){
            return $this->buildDomainObject($row);
        } else {
            throw new Exception("No article matching id ".$id);
        }
    }
    
    //Enregistrement d'un article
    public function save(Article $article) {
        $articleData = array(
            'art_title' => $article->getTitle(),
            'art_content' => $article->getContent(),
            );

        if ($article->getId()) {
            // The article has already been saved : update it
            $this->getDb()->update('t_article', $articleData, array('art_id' => $article->getId()));
        } else {
            // The article has never been saved : insert it
            $this->getDb()->insert('t_article', $articleData);
            // Get the id of the newly created article and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $article->setId($id);
        }
    }

    //Suppresion d'un article
    public function delete($id) {
        // Delete the article
        $this->getDb()->delete('t_article', array('art_id' => $id));
    }
    
    //Construit un objet Article
    protected function buildDomainObject($row){
        $article =  new Article();
        $article->setId($row['art_id']);
        $article->setTitle($row['art_title']);
        $article->setContent($row['art_content']);
        return $article;
    
    }
}

