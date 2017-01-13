<?php
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
?>
