<?php

namespace App\Model;

class Todo
{
   protected $database;

   public function __construct(\PDO $database)
   {
      $this->database = $database;

   }

   public function getTasks ()
   {
     $sql = $this->database->prepare('SELECT * FROM tasks');
     $sql->execute();
     return $sql->fetchAll();

   }
/******get single task by id ********/
   public function getTask ($task_id)
   {
     $sql = $this->database->prepare('SELECT * FROM tasks WHERE id = :id');
     $sql->bindParam('id' , $task_id);
     $sql->execute();
     return $sql->fetch();

   }

/******create a new task ********/
   public function createTask($data)
   {
      $sql = $this->database->prepare('INSERT INTO tasks (task, status) VALUES (:task, :status)');
      $sql->bindParam('task' , $data['task']);
      $sql->bindParam('status' , $data['status']);
      $sql->execute();
      return $this->getTask($this->database->lastInsertId());


   }
/******Update an existing task ********/
   public function updateTask($data)
   {
      $sql = $this->database->prepare('UPDATE tasks SET task = :task, status = :status WHERE id = :id');
      $sql->bindParam('task' , $data['task']);
      $sql->bindParam('status' , $data['status']);
      $sql->bindParam('id' , $data['id']);
      $sql->execute();
      return $this->getTask($data['id']);


   }
   /******delete a task  ********/
   public function deleteTask($task_id)
   {
      $sql = $this->database->prepare('DELETE FROM tasks WHERE id = :id');
      $sql->bindParam('id' , $task_id);
      $sql->execute();

      //after deleting task return the message
      return ['message' => 'The course was deleted successfully'];


   }


}
