<?php 

namespace UseSession;

   class Sessions
   {
       public static function Use(){
         
            if ( !session_id() )
            {
                session_start();
            }        
          //  d(session_id());
       }
   }
?>