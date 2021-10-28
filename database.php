<?php
    function connect(){
        $config = parse_ini_file('database.ini');
        $con = mysqli_connect("database.xxxx.com",$config['username'],$config['password'],$config['db']);
        if(!$con){
            die("Failed to connect to Database"); 
        }
        return $con;
    }
    $con = connect();
?>
