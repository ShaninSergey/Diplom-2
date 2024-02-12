<?php
	
namespace PDO_conection; 

use PDO; 
             
   class Conect
   {
	   
       public static function pdo() //статичная функция можно использовать без объявления класса
       {

           $driver = "mysql";
           $host = "localhost";
           $db_name = "DIPLOM2";
           $username = "root";
           $password = "";
           return new PDO("$driver:host=$host; dbname=$db_name", $username, $password);

       }
   }  
?>

