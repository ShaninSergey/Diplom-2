<?php


namespace App;

use Aura\SqlQuery\QueryFactory;
use Conection_pdo;
use PDO;

   class QueryBuilder
   {
	  
      protected $pdo;
      protected $queryFactory; 
	  
	  public function __construct(PDO $pdo)
      {
        $this -> pdo = $pdo;
        $this -> queryFactory = new QueryFactory('mysql');
	  }	  

//-----------------------------------------------------
        public function getPDO()
        {
            return $this->pdo; 
        }

//-----------------------------------------------------
 
      public function getAll($table)
      {

          $select = $this->queryFactory->newSelect();

          $select->cols(['*'])->from($table);

          $sth = $this->pdo->prepare($select->getStatement());

          // bind the values and execute
          $sth->execute($select->getBindValues());

          // get the results back as an associative array
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
          
          return $result;
      }

//-----------------------------------------------------

      public function getOne($table,$id)
      {

          $select = $this->queryFactory->newSelect();

          $select->cols(['*'])->from($table)->where('id = :id', ['id' => $id]) ;

          $sth = $this->pdo->prepare($select->getStatement());

          // bind the values and execute
          $sth->execute($select->getBindValues());

          // get the results back as an associative array
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);

          return $result;
      }

  //-----------------------------------------------------
     
      public function getOneByUserID($table,$user_id)
      {

          $select = $this->queryFactory->newSelect();

          $select->cols(['*'])->from($table)->where('user_id = :user_id', ['user_id' => $user_id]) ;

          $sth = $this->pdo->prepare($select->getStatement());

          // bind the values and execute
          $sth->execute($select->getBindValues());

          // get the results back as an associative array
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);

          return $result;
      }      

 //-----------------------------------------------------

     public function insert($table, $data)
     {
         $insert = $this->queryFactory->newInsert();

         $insert->into($table)->cols($data);

         // prepare the statement
         $sth = $this->pdo->prepare($insert->getStatement());

         // execute with bound values
         $sth->execute($insert->getBindValues());
     }

//-----------------------------------------------------

    public function update($table, $id, $data)
    {
            $update = $this->queryFactory->newUpdate();

        //    $update->table($table)->cols($data)->where('id=:id',['id'=>$id]); // РАБОТАЕТ ЭТОТ ВАРИАНТ
            $update->table($table)->cols($data)->where('id=:id')->bindValue('id',$id);

            // prepare the statement
            $sth = $this->pdo->prepare($update->getStatement());

            // execute with bound values
            $sth->execute($update->getBindValues());            
    }    

//-----------------------------------------------------

public function updateUserID($table, $user_id, $data)
{
        $update = $this->queryFactory->newUpdate();

    //    $update->table($table)->cols($data)->where('id=:id',['id'=>$id]); // РАБОТАЕТ ЭТОТ ВАРИАНТ
        $update->table($table)->cols($data)->where('user_id=:user_id')->bindValue('user_id',$user_id);

        // prepare the statement
        $sth = $this->pdo->prepare($update->getStatement());

        // execute with bound values
        $sth->execute($update->getBindValues());            
}    



//-----------------------------------------------------

    public function delete($table, $id)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
        ->from($table)           // FROM this table
        ->where('id = :id')      // AND WHERE these conditions
        ->bindValue('id',$id);   // bind one value to a placeholder
       
        $sth = $this->pdo->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues());        

    }    


    public function deleteByUserID($table, $user_id)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
        ->from($table)           // FROM this table
        ->where('user_id = :user_id')      // AND WHERE these conditions
        ->bindValue('user_id',$user_id);   // bind one value to a placeholder
       
        $sth = $this->pdo->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues());        

    }      
}  
?>

