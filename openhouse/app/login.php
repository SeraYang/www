<?php
    /* When the login information is confirmed, all related information
     * will be transferred to the android equipment by JSON. 
     * This way, is convinent to pass information between Activities
     * of Android App. And reduce the accesses of the server.
     * 
     * But for storing new information to the server, there should be a 
     * server run in the background of the App. As long as there is new 
     * information generated, there will be a request for storing this
     * new to the server. If there is no Internet available, store it 
     * in the SQLite. Try to access the Internet periodically in the
     * background.
     *
     */

    // These variables define the connection information 
    // for your MySQL database 
    //make the necessary changes (mybringback_travis, etc.)
    $dbusername = "root"; 
    $dbpassword = "Yang123"; 
    $dbhost = "localhost"; 
    $dbname = "ohDB_AGENT"; 

    // fetch POST elements
    if(isset($_POST['email']) && isset($_POST['password'])){
        $postemail = $_POST['email'];
        $postpassword = $_POST['password'];    
        $good = true;
    }else{
        $good = false;
    }

    // array for JSON response
    $JSONrespon = array();
    
?>
<?php
    // this is to check if user exists.
    //function checkemail($conn,$email){
    //    $select = "SELECT COUNT(email) FROM user where email=$email;";
    //    foreach ($conn->query($select) as $row){
    //        if($row['count(email)'] > 0){
    //            return true;
    //        }else{
    //            return false;
    //        }
    //    }
    //}

    // check if password right
    function checkpassword($conn,$postemail,$postpassword){
        $select = "SELECT password FROM user where email=\"$postemail\";";
        foreach($conn->query($select) as $row){
            if($row['password'] == $postpassword){
                return true;
            }else{
                return false;
            }
        }
    }

    if($good){     
        try{
            $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if(checkpassword($conn,$postemail,$postpassword)){
                $JSONrespon['status'] = 1;
                $JSONrespon['message'] = 'Login succeed';
            }else{
                $JSONrespon['status'] = 0;
                $JSONrespon['message'] = 'Login failed';
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
    }
?>
