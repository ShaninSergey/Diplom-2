<?php 
  
namespace Redirects;

class Redirect{

    public static function R($path)
    {
        header("Location: /{$path}"); 
    }
}
 

?>