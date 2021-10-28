<?php

   include 'token.php';
   include 'database.php';

    $finished = new stdClass();
 
    if (isset($_POST['token']) && $_POST['token'] == $_SESSION['csrf_token'] ){
        regenerateToken();

        removeProject($_POST['id'],$con);

    }else{
         echo "Token not correct."; 
    }

    function removeProject($token,$con){
        $statement = $con->prepare("DELETE FROM `approval_status` WHERE TOKEN = ? ");
        
        if ($statement == false){
            echo htmlspecialchars($con->error);
        }

        $statement->bind_param("s",$token);
        $statement->execute();
        $statement -> close();
        
    }

?>