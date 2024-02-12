<?php 
 
namespace Conntrollers;  





use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use UseSession\Sessions;

use PDO_conection\Conect;

use \Delight\Auth\Auth;
use \Delight\Auth\Role;
use \League\Plates\Engine;
use \Users\User;
use Redirects\Redirect;

use function Tamtamchik\SimpleFlash\flash; // флэшсообщение
use PDO;

require '../vendor/autoload.php'; // подключение всех пакетов

Sessions::Use(); 

class HomeController
{
     private $templates; 
     private $auth;
     private $qb;
     
     public function __construct(QueryBuilder $qb, Engine $engine, User $auth )
     {
         $this->qb = $qb;
         $this->templates = $engine; 
         $this->auth = $auth;         
         
     }

//--------------------------------------------------------------------------------------

public function update_media()
{
  
  if($this->auth->getUserId()==$_POST['id'] || $this->auth->isAdmin())
  {    
    $user_id = $_POST['user_id']; 
    $file = $_FILES['file'];
    $tmp_name = $file['tmp_name'];  
    $name_old = basename($file["name"]);

    $user = $this->qb->getOneByUserID('content',$user_id);
    $user = $user[0];

   // var_dump(file_exists("../views/templates/img/demo/avatars/".$user['avatar']));
  //  var_dump(is_dir("../views/templates/img/demo/avatars/"));

  //---------------------------------------------------
  // удаление старой катинки 
    if(mb_strlen($user['avatar'])>=4)
    {
       unlink("../views/templates/img/demo/avatars/".$user['avatar']);  // удаление старого файла 
    } 
    move_uploaded_file($tmp_name, "../views/templates/img/demo/avatars/$name_old"); // перемещение файла в новую папку
  //--------------------------------------------------------------------------
  //  новое имя файла  

      $res = pathinfo($file['name']);
      $name_new = uniqid("IMG_",false).".".$res['extension'];  
      
  //--------------------------------------------------------------------------  
  
     rename("../views/templates/img/demo/avatars/$name_old","../views/templates/img/demo/avatars/$name_new");
     
     $this->qb->update('content',$user['id'],['avatar' => $name_new]);
     
     Redirect::R('index');
  }

  else
  {
     Redirect::R('index'); 
  }  
}  

public function media($user_id)
{
  if($this->auth->getUserId()==$user_id || $this->auth->isAdmin())
  {     

      $user = $this->qb->getOneByUserID('content',$user_id);

      $user = $user[0];

      if(is_array($user) && !empty($user))
      {
           echo $this->templates->render('page_media',['message' => $this->auth->getMessage(),
                                                      'user'    => $user]);         
      }
      else
      {
           Redirect::R('index');
      }     
  }
  else
  {
       Redirect::R('index');
  } 
}

//--------------------------------------------------------------------------------------

public function update_security()
{


   if($this->auth->getUserId()==$_POST['id'] || $this->auth->isAdmin())
   {
      $this->qb->updateUserID('content', $_POST['id'], ['email' => $_POST['email']]);
      
      $this->qb->update('users',$_POST['id'],['email'     => $_POST['email']]); // верификация пользователя
      $this->qb->update('users',$_POST['id'],['verified' => 1]); // верификация пользователя

            
       if($_POST['password_ver'] == $_POST['password_new'])
       {
          $this->auth->change_password($_POST['password_old'],$_POST['password_new']);
          var_dump($this->auth->getMessage());
          $this->auth->setMessage('Данные пользователя обновлены');
       }

       Redirect::R('index');
   }  

}  

public function security($user_id)
{
     
  if($this->auth->getUserId()==$user_id || $this->auth->isAdmin())
  {     

      $user = $this->qb->getOne('users',$user_id);

      $user = $user[0];

      if(is_array($user) && !empty($user))
      {
           echo $this->templates->render('page_security',['message' => $this->auth->getMessage(),
                                                      'user'    => $user]);         
      }
      else
      {
           Redirect::R('index');
      }     
  }
  else
  {
       Redirect::R('index');
  } 
  
}

//--------------------------------------------------------------------------------------
  
public function status($user_id)
{
  if($this->auth->getUserId()==$user_id || $this->auth->isAdmin())
  {
      $user = $this->qb->getOneByUserID('content',$user_id);

      $user = $user[0];
      
      if(is_array($user) && !empty($user))
      {
          
           echo $this->templates->render('page_status',['message' => $this->auth->getMessage(),
                                                      'user'    => $user]);         
      }
      else
      {
           Redirect::R('index');
      }     
  }
  else
  {
       Redirect::R('index');
  }  
}

//--------------------------------------------------------------------------------------

public function profile($user_id)
{
     if($this->auth->getUserId()==$user_id || $this->auth->isAdmin())
     {
         $user = $this->qb->getOneByUserID('content',$user_id);

         $user = $user[0];
         
         if(is_array($user) && !empty($user))
         {
             
              echo $this->templates->render('page_profile',['message' => $this->auth->getMessage(),
                                                         'user'    => $user]);         
         }
         else
         {
              Redirect::R('index');
         }     
     }
     else
     {
          Redirect::R('index');
     }    
} 
//--------------------------------------------------------------------------------------

     public function update_status()
     {
        if($this->auth->getUserId()==$_POST['user_id'] || $this->auth->isAdmin())
        {
           $this->qb->update('content', $_POST['id'], ['status' => $_POST['status']]);
           
           $this->auth->setMessage('Статус пользователя обновлен');
           
            Redirect::R('index');
        }  
     }     

//--------------------------------------------------------------------------------------

     public function updateUserData()
     {
        if($this->auth->getUserId()==$_POST['user_id'] || $this->auth->isAdmin())
        {
           $this->qb->update('content', $_POST['id'], ['name'     => $_POST['name'],
                                                       'position' => $_POST['position'],
                                                       'phone'    => $_POST['phone'],
                                                       'address'  => $_POST['address']]);
           
           $this->auth->setMessage('Данные пользователя обновлены');
           
            Redirect::R('index');
        }  
     }     

//--------------------------------------------------------------------------------------
  
   public function edit($user_id)
   {
     if($this->auth->getUserId()==$user_id || $this->auth->isAdmin())
     {
         $user = $this->qb->getOneByUserID('content',$user_id);

         $user = $user[0];
         
         if(is_array($user) && !empty($user))
         {
             
              echo $this->templates->render('page_edit',['message' => $this->auth->getMessage(),
                                                         'user'    => $user]);         
         }
         else
         {
              Redirect::R('index');
         }     
     }
     else
     {
          Redirect::R('index');
     }  
   }

//=======================================================================    
// перешли на стартовую страницу  

     public function index()
     {
          if($this->auth->isLoggedIn())
          {
               $users = $this->qb->getAll('content');
              
               echo $this->templates->render('page_users',['message' => $this->auth->getMessage(),
                                                           'users'   => $users,
                                                           'admin'   => $this->auth->isAdmin(),
                                                           'userID'  => $this->auth->getUserId()]);
               $this->auth->clearMessage();             
          }
          else
          {
               Redirect::R('index');
          }
     }

//=======================================================================
// перешли на страницу регистрации

public function in_registration_page() //$vars
{
     if($this->auth->isLoggedIn())
     {
          echo $this->templates->render('page_users',['message' => $this->auth->getMessage()]);  // если уже вошел то перенаправить на страницу со списком пользователе
     }
     else
     {
          echo $this->templates->render('page_register',[]); 
     }     
}

//=======================================================================
// регистрация нового пользователя

     public function registration() //$vars
     {
         
          if($this->auth->isLoggedIn())
          {
               Redirect::R('index');
          }
          else
          {
               $username = $_POST['username'];
               $email    = $_POST['email'];
               $password = $_POST['password'];
               $role = $_POST['role'];
     
               // добавить админ или нет !!!!!!!!!!!!!!!!!!!!!!
     
               $userID = $this->auth->registration($username,$email,$password); // добавляем пользователя
               
               if($userID >= 0)
               {
                  if($role==="admin")
                  {
                         $this->auth->addRoleByID($userID,Role::ADMIN);  // присвоение роли ADMIN(1)/AUTHOR(2)
                  }
                  else
                  {
                         $this->auth->addRoleByID($userID,Role::AUTHOR);  // присвоение роли ADMIN(1)/AUTHOR(2)
                  }

                  echo $this->templates->render('page_login',['message' => $this->auth->getMessage()]);           
               }
               else
               {
                  echo $this->templates->render('page_register',['message' => $this->auth->getMessage()]);           
               }

               $this->auth->clearMessage(); 
          }        
     }

 //=======================================================================
// перешли на страницу создания поьлзователя

public function in_create_user_page() //$vars
{
     if($this->auth->isLoggedIn() && $this->auth->isAdmin())
     {
          echo $this->templates->render('page_create_user',['message' => $this->auth->getMessage()]);
     }
     else
     {
          echo $this->templates->render('page_login',[]); 
     }     
}    


public function create_user() //$vars
{
     if($this->auth->isLoggedIn() && $this->auth->isAdmin())
     {

          $userID = $this->auth->registration($_POST['username'], $_POST['email'], $_POST['password']); // добавляем пользователя
          
          if($userID >= 0)
          {
             
             //----------------------------------------------------------------
             //аватар
                    $file = $_FILES['file'];
                    $tmp_name = $file['tmp_name'];  
                    $name_old = basename($file["name"]);


                    move_uploaded_file($tmp_name, "../views/templates/img/demo/avatars/$name_old"); // перемещение файла в новую папку
                    //--------------------------------------------------------------------------
                    //  новое имя файла  
               
                         $res = pathinfo($file['name']);
                         $name_new = uniqid("IMG_",false).".".$res['extension'];  
                         
                    //--------------------------------------------------------------------------  
                    
                    rename("../views/templates/img/demo/avatars/$name_old","../views/templates/img/demo/avatars/$name_new");
                    
             //----------------------------------------------------------------
            
              
             $this->qb->updateUserID('content',$userID, [
                                           'name'     => $_POST['name'],                                
                                           'email'    => $_POST['email'],                                
                                           'status'   => $_POST['status'],                                
                                           'phone'    => $_POST['phone'],                                
                                           'position' => $_POST['position'],                                
                                           'address'  => $_POST['address'],
                                           'avatar'   => $name_new                                
                                          ]);
             //var_dump($_POST); die; 
             echo $this->templates->render('page_create_user',['message' => $this->auth->getMessage()]);           
          }
          else
          {
             echo $this->templates->render('page_create_user',['message' => $this->auth->getMessage()]);           
          }

          $this->auth->clearMessage(); 
     }     
}    


//=======================================================================
// вход в систему

      public function login() //$vars
      {
         
          $flag = $this->auth->login($_POST['email'],$_POST['password']);
         
         if($flag==true)
         {
               
               $users = $this->qb->getAll('content');
               
               echo $this->templates->render('page_users',['message' => $this->auth->getMessage(),
                                                       'users'   => $users,
                                                       'admin'   => $this->auth->isAdmin(),
                                                       'userID'  => $this->auth->getUserId()]);
               $this->auth->clearMessage();             
         }
         else
         {
              echo $this->templates->render('page_login',['message' => $this->auth->getMessage()]);  
         }

      }   
     
//=======================================================================

    public function logout() //$vars
    {
      $this->auth->logout();  
      echo $this->templates->render('page_login',['message' => $this->auth->getMessage()]);  
    }      
    
//=======================================================================

    public function delit($user_id) //$vars
    {

       var_dump($user_id);
      
        $username = 'felix';
        $this->auth->deleteUserByID($user_id);
        $this->qb->deleteByUserID('content',$user_id);
        
        Redirect::R('index');
      
    } 
    
//=======================================================================


}

?>