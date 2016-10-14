<?php

namespace MicroCMS\Manager;

use MicroCMS\Domain\Comment;

Class CommentsManager extends Manager
{
    
    private $articlesManager;
    private $usersManager;
    
    public function setArticlesManager(ArticlesManager $articlesManager){
       $this->articlesManager = $articlesManager;
    }

    public function setUsersManager(UsersManager $usersManager){
       $this->usersManager = $usersManager;
    }

    public function findAllByArticle($articleId){
       $article = $this->articlesManager->find($articleId);
       
       $sql = $this->getDb()->prepare("SELECT com_id, com_content, usr_id FROM t_comment WHERE art_id = :art_id order by com_id");
       $sql->execute([':art_id' => $articleId]);
       $result = $sql->fetchAll();
       $comments = [];
       foreach ($result as $row){
           $comId = $row['com_id'];
           $comment = $this->buildDomainObject($row) ;
           $comment->setArticle($article);
           $comments[$comId] = $comment;
       }
       return $comments;
       
    }
    
    public function findAll(){
        $sql =  "SELECT * FROM t_comment ORDER BY com_id desc";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convertir la requête en objet Comment
        $comments = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            $comments[$id] = $this->buildDomainObject($row);
        }
        return $comments;
    }
    
    public function save(Comment $comment) {
        $commentData = array(
            'art_id' => $comment->getArticle()->getId(),
            'usr_id' => $comment->getAuthor()->getId(),
            'com_content' => $comment->getContent()
            );

        if ($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDb()->update('t_comment', $commentData, array('com_id' => $comment->getId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('t_comment', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }
    public function find($id) {
        $sql = "select * from t_comment where com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
    }


    public function delete($id) {
        // Delete the comment
        $this->getDb()->delete('t_comment', array('com_id' => $id));
    }
    
    public function deleteAllByArticle($articleId) {
        $this->getDb()->delete('t_comment', array('art_id' => $articleId));
    }
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('t_comment', array('usr_id' => $userId));
    }
    
    protected function buildDomainObject($row){
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        if(array_key_exists('art_id', $row)){
            $article = $this->articlesManager->find($row['art_id']);
            $comment->setArticle($article);
        }
        if (array_key_exists('usr_id', $row)) {
            // Find and set the associated author
            $userId = $row['usr_id'];
            $user = $this->usersManager->find($userId);
            $comment->setAuthor($user);
        }
        return $comment;
    }
    
}