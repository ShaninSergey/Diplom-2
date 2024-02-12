<?php 
   
namespace Users;

 use App\QueryBuilder;
 use Aura\SqlQuery\QueryFactory;
 use \Delight\Auth\Auth;
 use \Delight\Auth\Role;

   class User
   {
       private $auth;
       private $qb;
       private $message;
       private $user_ID;

       public function __construct(QueryBuilder $qb,  Auth $auth)
       {
         $this -> qb      = $qb; 
         $this -> auth    = $auth;
         $this -> message = '';

       }



//==========================================================================================================================
// регистрация нового пользователя с одновременной верификацией email

    public function registration($username, $email, $password) //$_POST['email'], $_POST['password'], $_POST['username']
    {
        $user_ID = -1;
        try
        {
            $user_ID = $this->auth->register($email, $password, $username, function ($selector, $token)
            {
                // $this -> message = 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
            });

            $this -> message = 'Новый пользователь добавлен в БД ';
        }
        catch (\Delight\Auth\InvalidEmailException $e)
        {
            $this -> message = 'Неверный адрес электронной почты';
        }
        catch (\Delight\Auth\InvalidPasswordException $e)
        {
            $this -> message = 'Неверный пароль';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e)
        {
            $this -> message = 'Пользователь уже существует';
        }
        catch (\Delight\Auth\TooManyRequestsException $e)
        {
            $this -> message = 'Слишком много запросов';
        }
       

       if($user_ID >= 0)
       {  
          $this->qb->update('users',$user_ID,['verified' => 1]); // верификация пользователя
          $this->qb->insert('content',['user_id' => $user_ID]);  // добавляем запись в связанной таблице
       }   

       return $user_ID;
    }

 
//==========================================================================================================================

    public function email_verification($selector, $token) //$_GET['selector'], $_GET['token']
    {
        $flag = false;
        try
        {
            $this->auth->confirmEmail($selector, $token);
        
            $this -> message = 'Email верифицирован';

            $flag = true;
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e)
        {
            $this -> message = 'Invalid token';
        }
        catch (\Delight\Auth\TokenExpiredException $e)
        {
            $this -> message = 'Token expired';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e)
        {
            $this -> message = 'Email уже существует';
        }
        catch (\Delight\Auth\TooManyRequestsException $e)
        {
            $this -> message = 'Слишком много запросов';
        }

        return $flag;
        //echo $this->templates->render('registration', ['name' => 'Jonathan']);
    }  

//==========================================================================================================================

    public function login($email, $password) //$_POST['email'], $_POST['password']
    {
        $flag = false;
        try
        {
            $this->auth->login($email, $password);

            $this -> message = 'Пользователь вошел';

            $flag = true;
        }
        catch (\Delight\Auth\InvalidEmailException $e)
        {
            $this -> message = 'Неверный email';
        }
        catch (\Delight\Auth\InvalidPasswordException $e)
        {
            $this -> message = 'Неверный пароль';
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e)
        {
            $this -> message = 'Email не верифицирован';
        }
        catch (\Delight\Auth\TooManyRequestsException $e)
        {
            $this -> message = 'Слишком много запросов';
        }  

        return $flag;
    }   

//==========================================================================================================================

    public function logout() //$vars
    {
        $this->auth->logOut();
    }

//==========================================================================================================================

    public function change_password($password_old, $password_new) //$_POST['oldPassword'], $_POST['newPassword']
    {
        try 
        {
            $this->auth->changePassword($password_old, $password_new);
        
            $this -> message = 'Пароль был изменен';
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            $this -> message = 'Не авторизован';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this -> message = 'Неверный пароль';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this -> message = 'Слишком много запросов';
        }
    }  

//==========================================================================================================================

    public function change_email($password, $email_new ) //$vars
    {
        try 
        {
            if ($this->auth->reconfirmPassword($password)) 
            {
                $this->auth->changeEmail($email_new, function ($selector, $token) {
                   // $this -> message = 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email to the *new* address)';
                   // $this -> message = '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                   // $this -> message = '  For SMS, consider using a third-party service and a compatible SDK';
                });
        
                $this -> message = 'Изменение вступит в силу, как только будет подтвержден новый адрес электронной почты';
            }
            else {
                $this -> message = 'We can\'t say if the user is who they claim to be';
            }
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this -> message = 'Неверный email';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this -> message = 'Email уже существует';
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this -> message = 'Учетная запись не верифицирована';
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            $this -> message = 'Пользователь не вошел';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this -> message = 'Слишком много запросов';
        }
    }

//==========================================================================================================================

    public function isLoggedIn()
    {
        return $this->auth->isLoggedIn();
    }

//==========================================================================================================================

    public function getUserId()
    {
        return $this->auth->getUserId();
    }

//==========================================================================================================================

    public function getUsername()
    {
        return $this->auth->getUsername();
    }

//==========================================================================================================================

    public function getEmail()
    {
        return $this->auth->getEmail();
    }

//==========================================================================================================================

    public function isRemembered()
    {
        return $this->auth->isRemembered();
    }
//==========================================================================================================================

    public function isAdmin()
    {
        return $this->auth->hasRole(\Delight\Auth\Role::ADMIN);
    }

//==========================================================================================================================
// функции администратора
//==========================================================================================================================
// добавление пользователя

    public function createUser($username, $email, $password) //$_POST['email'], $_POST['password'], $_POST['username']
    {
        try 
        {
            $userId = $this->auth->admin()->createUser($email, $password, $username);
        
            $this -> message = 'We have signed up a new user with the ID ' . $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this -> message = 'Invalid email address';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this -> message = 'Invalid password';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this -> message = 'User already exists';
        }
    }

//==========================================================================================================================
// удаление пользователя из списка

    public function deleteUserByID($userID) 
    {
        try 
        {
            $this->auth->admin()->deleteUserById($userID);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            $this -> message = 'Unknown ID';
        }
    }    

//--------------------------------------------------------------------------------------------------------------------------

    public function deleteUserByEmail($userEmail) 
    {
        try 
        {
            $this->auth->admin()->deleteUserByEmail($userEmail);
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this -> message = 'Unknown email address';
        } 
    }   

//--------------------------------------------------------------------------------------------------------------------------

    public function deleteUserByUsername($username) 
    {
        try 
        {
            $this->auth->admin()->deleteUserByUsername($username);
        }
        catch (\Delight\Auth\UnknownUsernameException $e) {
            $this -> message = 'Unknown username';
        }
        catch (\Delight\Auth\AmbiguousUsernameException $e) {
            $this -> message = 'Ambiguous username';
        }
    }

//==========================================================================================================================
// Добавление роли

    public function addRoleByID($userID, $role = Role::ADMIN) 
    {
        try 
        {
            $this->auth->admin()->addRoleForUserById($userID, $role);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            $this -> message = 'Unknown user ID';
        }
    }

//--------------------------------------------------------------------------------------------------------------------------

    public function addRoleByEmail($userEmail, $role = Role::ADMIN) 
    {
        try 
        {
            $this->auth->admin()->addRoleForUserByEmail($userEmail, $role);
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this -> message = 'Unknown email address';
        }
    }

//--------------------------------------------------------------------------------------------------------------------------

    public function addRoleByUsername($username, $role = Role::ADMIN) 
    {
        try 
        {
            $this->auth->admin()->addRoleForUserByUsername($username, $role);
        }
        catch (\Delight\Auth\UnknownUsernameException $e) {
            $this -> message = 'Unknown username';
        }
        catch (\Delight\Auth\AmbiguousUsernameException $e) {
            $this -> message = 'Ambiguous username';
        }
    }

//==========================================================================================================================
// Удаление роли

    public function removeRoleByID($userID, $role = Role::ADMIN) 
    {
        try 
        {
            $this->auth->admin()->removeRoleForUserById($userID, $role);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            $this -> message = 'Unknown user ID';
        }
    }

//--------------------------------------------------------------------------------------------------------------------------

    public function removeRoleByEmail($userEmail, $role = Role::ADMIN) 
    {
        try 
        {
            $this->auth->admin()->removeRoleForUserByEmail($userEmail, $role);
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this -> message = 'Unknown email address';
        }
    }

//--------------------------------------------------------------------------------------------------------------------------

    public function removeRoleByUsername($username, $role = Role::ADMIN) //
    {
        try 
        {
            $this->auth->admin()->removeRoleForUserByUsername($username, $role);
        }
        catch (\Delight\Auth\UnknownUsernameException $e) {
            $this -> message = 'Unknown username';
        }
        catch (\Delight\Auth\AmbiguousUsernameException $e) {
            $this -> message = 'Ambiguous username';
        }
    }

//==========================================================================================================================
// Получение роли пользователя

    public function getRoleListByID($userID) //
    {
       return $this->auth->admin()->getRolesForUserById($userID);
    }

//--------------------------------------------------------------------------------------------------------------------------

    public function getRoleByID($userID, $role = Role::ADMIN) //
    {
        try 
        {
            if ($this->auth->admin()->doesUserHaveRole($userID, $role)) {
                $this -> message = 'The specified user is an administrator';
            }
            else {
                $this -> message = 'The specified user is not an administrator';
            }
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            $this -> message = 'Unknown user ID';
        }
    }

//--------------------------------------------------------------------------------------------------------------------------
    public function getRole() 
    {
       return $this->auth->getRoles();
    }

//==========================================================================================================================
// Изменение пароля пользователя

    public function setPasswordByID($userID, $password_new) //
    {

        try 
        {

            $this->auth->admin()->changePasswordForUserById($userID,  $password_new);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            $this -> message = 'Unknown ID';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this -> message = 'Invalid password';
        }

    }

//--------------------------------------------------------------------------------------------------------------------------

    public function setPasswordByUsername($username, $password_new) //
    {
        try 
        {
            $this->auth->admin()->changePasswordForUserByUsername($username, $password_new);
        }
        catch (\Delight\Auth\UnknownUsernameException $e) {
            $this -> message = 'Unknown username';
        }
        catch (\Delight\Auth\AmbiguousUsernameException $e) {
            $this -> message = 'Ambiguous username';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this -> message = 'Invalid password';
        }
    }

//==========================================================================================================================

    public function getMessage()
    {
        return $this->message;
    } 

    public function setMessage($message)
    {
        $this->message = $message;
    } 

//--------------------------------------------------------------------------------------------------------------------------

    public function clearMessage()
    {
        $this->message = '';
    }     

}
?>