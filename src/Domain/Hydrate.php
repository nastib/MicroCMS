<?php

trait Hydrate
{
    //hydratation de l'objet   //////////////
    public function hydrate(array $donnee)
    {
      foreach($donnee as $key => $value){
        $methode = 'set'.ucfirst($key);
        if(method_exists($this,$methode)){
          $this->$methode($value);
        }
       }
    }
}
