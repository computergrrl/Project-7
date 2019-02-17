<?php

namespace App\Model;

class Todo
{
   protected $database;

   public function __construct(\PDO $database)
   {
      $this->database = $database;

   }

   public function getTodos ()
   {
     $sql = $this->database->prepare('SELECT * FROM tasks');
     $sql->execute();
     return $sql->fetchAll();

   }


}
