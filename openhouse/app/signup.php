<?php
    require_once("sharedFunc.php");
    // These variables define the connection information for your MySQL database 
    //make the necessary changes (mybringback_travis, etc.)

    // array for JSON response
//    $JSONrespon = array();
//
//    function executeSQL($sql,$dbname){
//        $dbusername = "root"; 
//        $dbpassword = "Yang123"; 
//        $dbhost = "localhost"; 
//
//        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);
//        // set the PDO error mode to exception
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        try{
//            $sqlResult = $conn->query($sql);
//            $conn = null;
//        }catch(PDOException $e){
//            $sqlResult = null;
//            $conn = null;
//        }
//
//        return $sqlResult;
//    }
    
//    function tabExist($tabName,$dbName){
//        $sql = "SHOW TABLES LIKE \"$tabName\";";
//
//        // create connection to mysql by PDO
//        $dbusername = "root"; 
//        $dbpassword = "Yang123"; 
//        $dbhost = "localhost"; 
//
//        $conn = new PDO("mysql:host=$dbhost;dbname=$dbName",$dbusername,$dbpassword);
//        // set the PDO error mode to exception
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $result = $conn->query($sql);
//        $conn = null;  // release pointer.
//        if($result->rowCount()>0) {return 1;}
//        else {return 0;}
//    }

    // fetch POST elements
    if(isset($_POST['firstname']) && isset($_POST['lastname'])
        && isset($_POST['email']) && isset($_POST['password'])){
        $postfirstname = $_POST['firstname'];
        $postlastname = $_POST['lastname'];
        $postemail = $_POST['email'];
        $postpassword = $_POST['password'];    
        $good = true;
    }else{
        $good = false;
    }

    
    // this is to check if user exists.
    function emailexist($email){
        //$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);
        //// set the PDO error mode to exception
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $select = "SELECT email FROM user where email=\"$email\";";
        foreach (executeSQL($select,'ohDB_AGENT') as $row){
            if($row['email'] == $email){
                return true;
            }else{
                return false;
            }
        }
    }

    // generate table name according to Email address.
    function tablename($emailAddre){
        $buffer = explode("@",$emailAddre);
        $firststr = $buffer[0];
        $tablename = $firststr;
        $buf = explode(".",$buffer[1]);
        foreach($buf as $x){
            $tablename .= '_' . $x;
        }
        return $tablename;
    }

    function createAccount($fname,$lname,$email,$pwd){
        $counter = 0;
        $tablename = tablename($email); // create tablename accounting to email Address.
        if(createUser($fname,$lname,$email,$pwd) == null) $counter++;
        if(createTableCLIENTS($tablename) == null) $counter++;
        if(createTableBSC($tablename) == null) $counter++;
        if(createTableCLIRELAT($tablename) == null) $counter++;
        if(createTableCLITAGS($tablename) == null) $counter++;
        if(createTableCLITYPES($tablename) == null) $counter++;
        if(createTablePROPERTY($tablename) == null) $counter++;
        if(createTablePROPLIST($tablename) == null) $counter++;
        //print '$counter is '.$counter;
        return $counter;
    }

    function createUser($fname,$lname,$email,$pwd){
        $sql = "INSERT INTO user (fName, lName, email, password) 
                    VALUES (\"$fname\",\"$lname\",\"$email\",\"$pwd\");";
        return executeSQL($sql,'ohDB_AGENT');
    }

    function createTableCLIENTS($tablename){
        $dbname = 'ohDB_CLIENTS';
        $sql = "CREATE TABLE $tablename LIKE TEMPLATE;";
        if(tabExist($tablename,$dbname)>0){
            $dropTable = "DROP TABLE $tablename;";
            executeSQL($dropTable,$dbname);
        }

        return executeSQL($sql,$dbname);
    }

    function createTableBSC($tablename){
        $dbname = 'ohDB_BUYER_SEARCH_CRITERIA';
        $sql = "CREATE TABLE $tablename LIKE TEMPLATE;";
        if(tabExist($tablename,$dbname)>0){
            $dropTable = "DROP TABLE $tablename;";
            executeSQL($dropTable,$dbname);
        }

        return executeSQL($sql,$dbname);
    }

    function createTableCLIRELAT($tablename){
        $dbname = 'ohDB_CLIENTS_RELATIONSHIP';
        $sql = "CREATE TABLE $tablename LIKE TEMPLATE;";
        if(tabExist($tablename,$dbname)>0){
            $dropTable = "DROP TABLE $tablename;";
            executeSQL($dropTable,$dbname);
        }

        return executeSQL($sql,$dbname);
    }

    function createTableCLITAGS($tablename){
        $dbname = 'ohDB_CLIENTS_TAGS';
        $sql = "CREATE TABLE $tablename LIKE TEMPLATE;";
        if(tabExist($tablename,$dbname)>0){
            $dropTable = "DROP TABLE $tablename;";
            executeSQL($dropTable,$dbname);
        }

        return executeSQL($sql,$dbname);
    }

    function createTableCLITYPES($tablename){
        $dbname = 'ohDB_CLIENT_TYPES';
        $sql = "CREATE TABLE $tablename LIKE TEMPLATE;";
        if(tabExist($tablename,$dbname)>0){
            $dropTable = "DROP TABLE $tablename;";
            executeSQL($dropTable,$dbname);
        }

        return executeSQL($sql,$dbname);
    }

    function createTablePROPERTY($tablename){
        $dbname = 'ohDB_PROPERTY';
        $sql = "CREATE TABLE $tablename LIKE TEMPLATE;";
        if(tabExist($tablename,$dbname)>0){
            $dropTable = "DROP TABLE $tablename;";
            executeSQL($dropTable,$dbname);
        }

        return executeSQL($sql,$dbname);
    }

    function createTablePROPLIST($tablename){
        $dbname = 'ohDB_PROPERTY_LISTING';
        $sql = "CREATE TABLE $tablename LIKE TEMPLATE;";
        if(tabExist($tablename,$dbname)>0){
            $dropTable = "DROP TABLE $tablename;";
            executeSQL($dropTable,$dbname);
        }

        return executeSQL($sql,$dbname);
    }

    function deleteEntry($postemail){
        $dbname = 'ohDB_AGENT';
        $sql = "DELETE FROM user WHERE email=\"$postemail\";";

        executeSQL($sql,$dbname);
    }

    // check if password right
    //function checkpassword($conn,$postemail,$postpassword){
    //    $select = "SELECT password FROM user where email=$postemail;";
    //    foreach($conn->query($select) as $row){
    //        if($row['password'] == $postpassword){
    //            return true;
    //        }else{
    //            return false;
    //        }
    //    }
    //}
?>
<?php
    if($good){     
        try{

            if(emailexist($postemail)){
                $JSONrespon['status'] = -1;
                $JSONrespon['message'] = "The Account exists";
            }else{
                if(createAccount($postfirstname,$postlastname,$postemail,$postpassword)>0){
                    try{
                        deleteEntry($postemail);
                    }catch(PDOException $e){}

                    $JSONrespon['status'] = 0;
                    $JSONrespon['message'] = "fail to create an account";
                }else{
                    $JSONrespon['status'] = 1;
                    $JSONrespon['message'] = "Succeed Creating!";
                    
                }
            }
            // prepare sql and bind parameters
            //$stmt = $conn->prepare("INSERT INTO user 
            //    (fName,lName,email,password) VALUES
            //    (:firstname,:lastname,:email,:password)");
            //$stmt->bindParam(':firstname',$myfirstname);
            //$stmt->bindParam(':lastname',$mylastname);
            //$stmt->bindParam(':email',$postemail);
            //$stmt->bindParam(':password',$postpassword);
            //$myfirstname = 'Yifan';
            //$mylastname = 'Yang';
            //if($stmt->execute()){
            //    $JSONrespon["status"] = 1;
            //    $JSONrespon["message"] = 'Register succeed';
            //}else{
            //    $JSONrespon["status"] = 0;
            //    $JSONrespon["message"] = 'Insertion NOT executed';
            //}

            echo json_encode($JSONrespon);

        }catch(PDOException $e){
            //print "Error: ".$e->getMessage();
            $JSONrespon["status"] = 0;
            $JSONrespon["message"] = "Error: ".$e->getMessage();
            echo json_encode($JSONrespon);
        }
    }else{
        $JSONrespon["status"] = 0;
        $JSONrespon["message"] = "No email or password";
        echo json_encode($JSONrespon);
    }
?>
