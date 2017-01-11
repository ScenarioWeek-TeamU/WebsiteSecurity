<?php
function getUserIP()
{
    $ip = $_SERVER['REMOTE_ADDR'];

    return $ip;
}

function isInteger($input){
    return(ctype_digit(strval($input)));
}

function isLoggedIn(){
    if(isset($_SESSION['username'], $_SESSION['user_id'], $_SESSION['user_role'])){
        return true;
    }else{
        return false;
    }
}

function isAdmin(){
    if(isLoggedIn()){
        if(intval($_SESSION['user_role']) === 1){
            return true;
        }
    }
    return false;
}

function canPostSnippet(){
    if(isLoggedIn()){
        if(isAdmin() || intval($_SESSION['user_role']) === 2){
            return true;
        }
    }
    return false;
}

//Fallback for older versions of PHP
if(!function_exists('hash_equals'))
{
    function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}

//deletes a directory and all sub directory files
//http://stackoverflow.com/questions/3338123/how-do-i-recursively-delete-a-directory-and-its-entire-contents-files-sub-dir
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (is_dir($dir."/".$object))
           rrmdir($dir."/".$object);
         else
           unlink($dir."/".$object);
       }
     }
     rmdir($dir);
   }
 }

?>
