<?php
    // array for JSON response
    $JSONrespon = array();

    function executeSQL($sql,$dbname){
        $dbusername = "root"; 
        $dbpassword = "Yang123"; 
        $dbhost = "localhost"; 

        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $sqlResult = $conn->query($sql);
            $conn = null;
        }catch(PDOException $e){
            $sqlResult = null;
            $conn = null;
        }

        return $sqlResult;
    }


    function tabExist($tabName,$dbName){
        $sql = "SHOW TABLES LIKE \"$tabName\";";

        // create connection to mysql by PDO
        $dbusername = "root"; 
        $dbpassword = "Yang123"; 
        $dbhost = "localhost"; 

        $conn = new PDO("mysql:host=$dbhost;dbname=$dbName",$dbusername,$dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->query($sql);
        $conn = null;  // release pointer.
        if($result->rowCount()>0) {return 1;}
        else {return 0;}
    }
?>
