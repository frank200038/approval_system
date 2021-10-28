<?php
    
    if (session_id() == ""){
        session_start();
    }

    
    
    $_SESSION["submitted"] = false;

    if (!isset($_POST["remove"])){
        $currentDir = getcwd();
        $responseTotal = array();
        $response = new stdClass();

        if ($_SESSION["submitted"] == false){

            $_SESSION["submitted"] = true;
            $total = $_POST["total"];
            $uploadDirectory = "uploads/".$_POST["id"]."/";

            // Store all errors
            $errors = [];
            // Available file extensions
            $fileExtensions = ['jpeg','jpg','png'];

            for ($i = 0;$i<$total;$i++){

                $response = new stdClass();

                if(!empty($_FILES['file-'.$i] ?? null)) {
                    $fileName = $_FILES['file-'.$i]['name'];
                    $fileTmpName  = $_FILES['file-'.$i]['tmp_name'];
                    $fileType = $_FILES['file-'.$i]['type'];
                    $fileExtension = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));

                    $uploadPath = $currentDir ."/".$uploadDirectory . basename($fileName); 

                    if (!file_exists($currentDir."/".$uploadDirectory)) {
                        mkdir($currentDir."/".$uploadDirectory, 0777, true);
                    }

                    if (! file_exists($uploadPath)) {
                        if (! in_array($fileExtension,$fileExtensions)) {
                                $response->uploaded = "false";
                                $response->error = basename($fileName)." is not supported!\n Only JPEG, JPG, PNG images are supported";
                                array_push($responseTotal,$response);
                        }
                        if (empty($errors)) {
                            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
                            if ($didUpload) {
                                $response->uploaded = "true";
                                $response->link = $uploadDirectory.basename($fileName);
                                
                                array_push($responseTotal,$response);
                            } else {
                                $response->uploaded = "false";
                                $response->error = "An error occurrede:\n.".basename($fileName)."\n Try again.";
                                array_push($responseTotal,$response);
                            }
                        }
                    }else{
                        $response->uploaded = "false";
                        $response->error = basename($fileName)."\n already exists.";
                        array_push($responseTotal,$response);
                    }
                }
            }

            $_SESSION["submitted"] = false;

        }else{

            $response->uploaded = "false";
            $response->error = "Please wait until pictues are saved already exists.";
            array_push($responseTotal,$response);

        }
        
        echo json_encode($responseTotal);
    }else {
        $link = $_POST["remove"];
        $response = new stdClass();
        echo $link;
        if (file_exists($link)){
            unlink($link);
        }

    }
?>