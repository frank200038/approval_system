<?php
    if (session_id() == ""){
        session_start();
    }
    if (empty($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    function regenerateToken(){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>