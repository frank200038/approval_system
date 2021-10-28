<?php
   include 'token.php';
   include 'database.php';

    $_SESSION["submitted"] = false;
    $finished = new stdClass();
    

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    if (isset($_POST['token']) && $_POST['token'] == $_SESSION['csrf_token'] && ! $_SESSION["submitted"]){
        regenerateToken();

        $_SESSION["submitted"] = true;
        $name = "";
        $comment = "";
        $img = "";
        $link = "";
        $data = "";
        $password = "";
        $exist = false;
        $ifAllSet = array();
        $response = new stdClass();

        if (isset($_POST['name'])){
            $name = $_POST['name'];
            array_push($ifAllSet,true);
        }

        if (isset($_POST['comment'])){
            $comment = $_POST['comment'];
            array_push($ifAllSet,true);
        }

        if (isset($_POST['img'])){
            $img = $_POST['img'];
            array_push($ifAllSet,true);
        }

        if (isset($_POST['link'])){
            $link = $_POST['link'];
            array_push($ifAllSet,true);
            $exist = checkIfExist($link,$con);
        }

        if (isset($_POST['date'])){
            $date = $_POST['date'];
            array_push($ifAllSet,true);
        }

        if (isset($_POST['password'])){
            $password = $_POST['password'];
            array_push($ifAllSet,true);
        }
        
        if (!in_array(false,$ifAllSet) && $exist){
            $info = array($name,$comment,$img,$link);
            updateInfo($info,$con);
        }elseif (!in_array(false,$ifAllSet) && ! $exist) {
            $password = randomPassword();
            $info = array($name,$comment,$link,$img,$date,$password);
            createNewRow($info,$con);
            $finished -> password = $password;
        }

        $finished->finished = "true";
        $_SESSION["submitted"] = false;
        echo json_encode($finished);

    }else{
         echo "Token not correct."; 
    }

    function checkIfExist($id,$con){

        $statement = $con->prepare("SELECT * FROM approval_status WHERE TOKEN= ? ");
        $statement->bind_param('s',$id);
        $statement->execute();
        $result =  $statement->get_result();
        $numRows = mysqli_num_rows($result);

        if ($numRows > 0){
            return true;
        }

        $statement -> close();

        return false;
    }

    function updateInfo($info,$con){
        $statement = $con->prepare("UPDATE `approval_status` SET `NAME`= ?, `DESCRIPTION` = ? , `IMG_PATH` = ? WHERE TOKEN= ? ");
        $statement->bind_param('ssss',$info[0],$info[1],$info[2],$info[3]);
        $statement->execute();
        $statement->close();
    }

    function createNewRow($info,$con){
        $statement = $con->prepare("INSERT INTO `approval_status` (NAME,STATUS,DESCRIPTION,TOKEN,IMG_PATH,DATE,PASSWORD) VALUES (?,'NOT APPROVED',?,?,?,?,?)");

        if ($statement == false){
            echo htmlspecialchars($con->error);
        }

        $bind=$statement->bind_param('ssssss',$info[0],$info[1],$info[2],$info[3],$info[4],$info[5]);
        if ($bind == false){
            echo htmlspecialchars($statement->error);
        }
        $result = $statement->execute();
        if ($result == false){
            echo htmlspecialchars($statement->error);
        }
        $statement -> close();
        
    }
?>