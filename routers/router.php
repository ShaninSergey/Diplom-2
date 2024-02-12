<?php


use DI\ContainerBuilder;     // контейнер зависимостей
use Delight\Auth\Auth;       // авторизация
use \League\Plates\Engine;   // виды
use Users\User;
//use PDO;


//=========================================================================================

$containerBuilder = new ContainerBuilder; // контейнер для поиска всех зависимостей

// исключения при которых экземпляры класса будут создаваться по иному
$containerBuilder->addDefinitions([  
     
     Engine::class => function()
     {
         return new Engine("../views");
     },

     PDO::class => function()
     {
         $driver = "mysql";
         $host = "localhost";
         $db_name = "DIPLOM2";
         $username = "root";
         $password = "";
         return new PDO("$driver:host=$host; dbname=$db_name", $username, $password);         
     },

     Auth::class => function($container)
     {
         return new Auth($container->get('PDO'));
     }         

]);


$container = $containerBuilder->build();



 //d($container);

//=========================================================================================

//  маршруты

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
{
   /* 

    $r->addRoute('GET', '/home', ['Conntrollers\HomeController','index']); // [нэймспейс и имя класса контролера, метод класса]
    $r->addRoute('GET', '/about/{amount:\d+}', ['Conntrollers\HomeController','about']); // [нэймспейс и имя класса контролера, метод класса]
   
   
    $r->addRoute('GET', '/paging{?page=\d+}', ['Conntrollers\HomeController','paging']); // [нэймспейс и имя класса контролера, метод класса]
    $r->addRoute('GET', '/paging', ['Conntrollers\HomeController','paging']); // [нэймспейс и имя класса контролера, метод класса]


    $r->addRoute('GET', '/registration', ['Conntrollers\HomeController','registration']); // [нэймспейс и имя класса контролера, метод класса]
    $r->addRoute('GET', '/verification', ['Conntrollers\HomeController','email_verification']); // [нэймспейс и имя класса контролера, метод класса]
    $r->addRoute('GET', '/login'       , ['Conntrollers\HomeController','login']); // [нэймспейс и имя класса контролера, метод класса]
   
  */
  $r->addRoute('GET', '/',      ['Conntrollers\HomeController', 'index']);             // открываем страницу первый раз 
  $r->addRoute('GET', '/index', ['Conntrollers\HomeController', 'index']);        // открываем страницу логирования 
  
  $r->addRoute(['GET','POST'],  '/in_registration_page', ['Conntrollers\HomeController', 'in_registration_page']);        // заходим на форму регистрации 
 
  $r->addRoute('POST', '/registration', ['Conntrollers\HomeController', 'registration']); // регистрация нового пользователя 

  $r->addRoute('POST', '/login', ['Conntrollers\HomeController', 'login']);       // логирование 
 
  $r->addRoute(['GET','POST'], '/logout', ['Conntrollers\HomeController', 'logout']);             // сводные данные 
 
 
  $r->addRoute(['GET','POST'],  '/in_create_user_page', ['Conntrollers\HomeController', 'in_create_user_page']);        // заходим на форму регистрации 
 
  $r->addRoute('POST', '/create_user', ['Conntrollers\HomeController', 'create_user']);        // заходим на форму регистрации 


  $r->addRoute(['GET','POST'],  '/edit/{user_id:\d+}', ['Conntrollers\HomeController', 'edit']); // переход на страницу с данными юзера
  $r->addRoute(['GET','POST'],  '/update_user_data', ['Conntrollers\HomeController', 'updateUserData']); // редактирование юзера


  $r->addRoute(['GET','POST'],  '/status/{user_id:\d+}', ['Conntrollers\HomeController', 'status']); // переход на страницу с данными юзера
  $r->addRoute(['GET','POST'],  '/update_status', ['Conntrollers\HomeController', 'update_status']); // редактирование юзера

  $r->addRoute(['GET','POST'],  '/profile/{user_id:\d+}', ['Conntrollers\HomeController', 'profile']); // переход на страницу с данными юзера

  $r->addRoute(['GET','POST'],  '/security/{user_id:\d+}', ['Conntrollers\HomeController', 'security']); // переход на страницу с данными юзера
  $r->addRoute(['GET','POST'],  '/update_security', ['Conntrollers\HomeController', 'update_security']); // редактирование юзера


  $r->addRoute(['GET','POST'],  '/media/{user_id:\d+}', ['Conntrollers\HomeController', 'media']); // переход на страницу с данными юзера
  $r->addRoute(['GET','POST'],  '/update_media', ['Conntrollers\HomeController', 'update_media']); // редактирование юзера

  $r->addRoute(['GET','POST'],  '/delit/{user_id:\d+}', ['Conntrollers\HomeController', 'delit']); // переход на страницу с данными юзера

/*
    $r->addRoute('GET', '/form', ['Conntrollers\HomeController','form']);             // сводные данные 
  
  
    $r->addRoute('POST', '/test', ['Conntrollers\HomeController','test']);             // сводные данные 


    $r->addRoute('GET', '/status', ['Conntrollers\HomeController','status']);             // сводные данные 
     

    $r->addRoute('GET', '/verification', ['Conntrollers\HomeController','verification']); // верификация пользователя

    $r->addRoute('GET', '/registration', ['Conntrollers\HomeController','registration']); // регистрация нового пользователя 

    $r->addRoute('GET', '/delit'       , ['Conntrollers\HomeController','delit']);        // удаление юзера по имени
   
*/
});

//-----------------------------------------------------

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];  // Метод перехода GET/POST
$uri = $_SERVER['REQUEST_URI'];            // адрес URI


//-----------------------------------------------------
// функциональная обработка запроса

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?'))
{
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

//-----------------------------------------------------
// обработчик различных вариантов


$routeInfo = $dispatcher->dispatch($httpMethod, $uri);


switch ($routeInfo[0]) 
{
    case FastRoute\Dispatcher::NOT_FOUND:    // нет такого пути
        // ... 404 Not Found
        echo " Ошибка 404 ";
    break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED: // нет такого метода
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo " Метод не разрешен ";
    break;

    case FastRoute\Dispatcher::FOUND:   // есть и путь и метод
       
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        
       // var_dump($handler);

        $container->call($handler,$vars); 
    break;
}
  
?>