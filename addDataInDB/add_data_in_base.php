<?php 
   
//---------------------------------------------------------------
 
   function fild($i) 
   {
      if($i === 0) return "name";
      if($i === 1) return "position";
      if($i === 2) return "phone";
      if($i === 3) return "email";
      if($i === 4) return "address";
   }

//---------------------------------------------------------------
 
   function delitByID(PDO $pdo,$table,$id)
   {
      $sql = "DELETE FROM $table WHERE id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
   }

//---------------------------------------------------------------
 
   function cleare (PDO  $pdo,$table)
   {
      // Выполнение запроса
      $sql = "SELECT * FROM $table";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      
      $arrs = $stmt->fetchAll(PDO::FETCH_ASSOC);
     // d($arrs);
      // Вывод результатов
      foreach ($arrs as $arr) 
      {
        //echo ($arr['id']);
         delitByID($pdo,$table,$arr['id']);
      }
   }

//---------------------------------------------------------------
 
   function insert(PDO $pdo, $table, $arr)
   {
      $name = $arr['name'];
      $email = $arr['email'];
      $position = $arr['position'];
      $phone = $arr['phone'];
      $address = $arr['address'];

      $sql = "INSERT INTO $table (name, email, position, phone, address) VALUES (?,?,?,?,?)"; // Запрос INSERT
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$name, $email, $position, $phone, $address]); // Выполнение запроса
      d($stmt);
   }

//---------------------------------------------------------------
 
   function insertARR(PDO  $pdo, $table, $arrs)
   {
      foreach ($arrs as $arr) 
      {
         insert($pdo,$table,$arr);  
      }
   }

//---------------------------------------------------------------
 
   $txt = file_get_contents('dat.txt');
   
   $lines = explode("\n", $txt);

    $k=0; $n=0;

    $users = [[]];

   for($i=0; $i<count($lines); $i++)
   {
      $lines[$i] = trim($lines[$i]);

      if(empty($lines[$i]))
      {  
         $k++;
         $n=0;
         
         continue;
      }

       $users[$k][fild($n)] = $lines[$i];
       
       $n++;
   }

   $host = 'localhost'; // имя сервера базы данных
   $dbname = 'DIPLOM2'; // имя базы данных
   $username = 'root'; // имя пользователя базы данных
   $password = ''; // пароль пользователя базы данных
   $tabel = 'content';


   $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  // var_dump($users); // Результат должен быть объектом PDO  
   cleare ($pdo,'content');
   insertARR($pdo,'content',$users);
?>