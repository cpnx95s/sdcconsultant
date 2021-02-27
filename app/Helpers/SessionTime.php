<?php
namespace App\Helpers;

class   SessionTime{

    public static function setSessionTime($id,$menu,$_timeSecond){
        // echo $id;
        // echo $menu;
        // echo $_timeSecond.'<br>';
        session_start();
        if(!isset($_SESSION[$menu.$id])){
            $_SESSION[$menu.$id]=time();
            return 'true';

        }
        if(isset($_SESSION[$menu.$id]) && time()-$_SESSION[$menu.$id] > $_timeSecond){
                // echo $_SESSION[$menu.$id].'<br>';
                // echo time()-$_SESSION[$menu.$id].'<br>';
                unset($_SESSION[$menu.$id]);
                return 'true';

        }else{
            // echo $_SESSION[$menu.$id].'<br>';
            // echo time()-$_SESSION[$menu.$id].'<br>';
            return 'false';

        }

    }


}