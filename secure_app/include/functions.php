<?php
function displayError(){
    if(isset($_GET['err'])){
        //Prevent reflected XSS by escaping html chars
        $err = htmlspecialchars($_GET['err']);

        echo'
        <div style="color: red;" id="error_message">
            <center>
                <p class="error">' . $err . '</p>
            </center>
        </div>';
    }
}

function genSessionHash(){
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_browser = $_SERVER['HTTP_USER_AGENT'];

    return hash('sha512', $ip . $user_browser);
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


function isLoggedIn(){
    if(isset($_SESSION['username'], $_SESSION['user_id'], $_SESSION['user_role'], $_SESSION['session_hash'])){

        $session_hash = genSessionHash();

        if(hash_equals($_SESSION['session_hash'], $session_hash)){
            return true;
        }else{
            return false;
        }
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
?>
