<?php 

include 'token.php'; 
include 'database.php';

if (isset($_POST["token"]) && isset($_POST["password"])){
    if (isset($_POST['approve'])){
        approve($_POST["token"],$_POST['password'],$con);
    }elseif (isset($_POST['comment'])) {
        comment($_POST["token"],$_POST['password'],$_POST['comment'],$con);
    }else{
        getOneProject($_POST["token"],$_POST['password'],$con);
    }
    
}else{
    $response = new stdClass();
    $response->error = "Not enough param";
    echo json_encode($response);
}

function checkStatus($id,$pass,$con){
    $statement = $con->prepare("SELECT STATUS FROM `approval_status` WHERE TOKEN= ? AND PASSWORD = ?");
    $statement->bind_param('ss',$id,$pass);
    $statement->execute();
    $result = $statement->get_result();
    $rowCount = mysqli_num_rows($result);
    $response = new stdClass();

    if ($rowCount >= 1){
        $row = $result->fetch_assoc();
        return $row["STATUS"];
    }else{
        return "wrong";
    }

    $statement->close();

}
function comment($id,$pass,$comment,$con){
    $status = checkStatus($id,$pass,$con);
    $response = new stdClass();
    if ($status != "APPROVED"){
        $statement = $con->prepare("UPDATE `approval_status` SET `COMMENT` = ? WHERE TOKEN= ? AND PASSWORD = ?");
        $statement->bind_param('sss',$comment,$id,$pass);
        $statement->execute();
        $statement->close();
    }else{
        $response->error="Already Approved!";
    }
    
    echo json_encode($response);
}

function approve($id,$pass,$con){
    $status = checkStatus($id,$pass,$con);
    $response = new stdClass();
    if ($status != "APPROVED"){
        $statement = $con->prepare("UPDATE `approval_status` SET `STATUS`= 'APPROVED' WHERE TOKEN= ? AND PASSWORD = ?");
        $bind = $statement->bind_param('ss',$id,$pass);
        $statement->execute();
        $statement->close();
    }else{
        $response->error="Already Approved!";
    }

    echo json_encode($response);
}


function getOneProject($id,$pass,$con){
        
    $statement = $con->prepare("SELECT * FROM `approval_status` WHERE TOKEN= ? AND PASSWORD = ? ");
    $statement->bind_param('ss',$id,$pass);
    $statement->execute();
    $result = $statement->get_result();
    $rowCount = mysqli_num_rows($result);
    $response = new stdClass();

    if ($rowCount >= 1){
        $row = $result->fetch_assoc();

        $response->name = $row["NAME"];
        $response->status = $row["STATUS"];
        $response->img = $row["IMG_PATH"];
        $response->date = $row["DATE"];
        $response->comment = htmlspecialchars($row["COMMENT"]);
        $response->description = htmlspecialchars($row["DESCRIPTION"]);

    }else{
        $response->error="don't exist";
    }

    $statement->close();
    echo json_encode($response);
        
}

?>