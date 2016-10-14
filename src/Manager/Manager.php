<?php

namespace MicroCMS\Manager;

use Doctrine\DBAL\Connection;

abstract class Manager
{
    /**
     * propriétés
     */
    
     
    private $db;
    
    public function __construct(Connection $db) {
        $this->db = $db;
    }
    
    //Setters & Getters
    public function setDb($db){
        $this->db = $db;
    }
    
    public function getDb(){
        return $this->db;
    }
    
    /**
     * Builds a domain object frome DB row
     */
    protected abstract function buildDomainObject($row);
}
