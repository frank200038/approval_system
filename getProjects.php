<?php
   include 'token.php';
   include 'database.php';
    
    
    $url = 0;
    if (isset($_GET['token']) && $_GET['token'] == $_SESSION['csrf_token']){
        regenerateToken();

        $token = 0;
        if (isset($_GET["generate"]) && $_GET["generate"]== "1" ){
            $token = generateRandomString();
            $query = "SELECT TOKEN FROM `approval_status`";
            if(isset($query)){
                $result =  $con -> query($query);
                $data=array();

                while ($row = $result->fetch_assoc()){
                    $data[]=$row;
                }

                while (in_array($token,$data)){
                    $token = generateRandomString();
                }

                echo json_encode($token);
            }else{
                echo -1;
            }
        }else{
            $query = "SELECT NAME,STATUS,DESCRIPTION,COMMENT,TOKEN,IMG_PATH,PASSWORD,DATE FROM `approval_status`;";    
            if(isset($query)){
                $result =  $con -> query($query);
                $data=array();
                while ($row = $result->fetch_assoc()){
                    $data[]=$row;
                }
                echo json_encode($data);
            }else{
                echo -1;
            }
        }
    }else{
         echo "Token not correct."; 
    }

    

    mysqli_close($con)
?>