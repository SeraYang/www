<html>
    <head>
        <title> This is for Open House !!! </title>
        <?php
            echo "Below is using mysqli<br>";
            $servername = "localhost";
            $username = "root";
            $password = "Yang123";

            // Create connection
            $conn = new mysqli($servername, $username,$password);
            // Check connection
            if($conn -> connect_error){
                die("Connection failed: ".$conn -> connect_error);
            }
                echo "Connected successfully";
            
        ?>
    </head>

    <body>
        <?php

            //echo "<br>Below is using PDO:<br>";
            //$pdoserver_name = "localhost";
            //$pdouser_name = "openhouse";
            //$pdopassword = "test";

            //// Create connection
            //try{$conn = new PDO("mysql:host=$pdoserver_name;
            //                                dbname=ohDB",
            //                                    $pdouser_name, $pdopassword);
            //    // set the PDO error mode to exception
            //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully. hahaha";
            //}catch(PDOException $e){
            //    echo "Connection failed: ".$e->getMessage();
            //}

            //
            //$sql_insert = "INSERT INTO MyGuests (firstname,lastname,email) VALUES ('Yifan','Yang','yyang39@gmail.com')";
            //$conn->query($sql_insert);
        

            //echo "Hello, Vishal<br>";

            //function __autoload($className){
            //    include("class_".ucfirst($className).".php");
            //}
        ?>
        <center>
            <h2>calculator</h2>
            <hr>
            <a href="index.php?action=1">rectangle</a>
            <a href="index.php?action=2">triangle</a>
            <a href="index.php?action=3">circle</a>
        </center>
        <?php
            //switch($_REQUEST["action"]){
            //    case 1:
            //        $form = new Form("rectangle",$_REQUEST,"index.php");
            //        echo $form;
            //        break;
            //    case 2:
            //        $form = new Form("triangle",$_REQUEST,"index.php","post","_blank");
            //        echo $form;
            //        break;
            //    case 3:
            //        $form = new Form("circle",$_REQUEST,"index.php");
            //        echo $form;
            //        break;
            //    default:
            //        echo "Choose a shape<br>";
            //}

            //if(isset($_REQUEST["act"])){
            //    switch($_REQUEST["act"]){
            //        case 1:
            //            $shape = new Rect($_REQUEST);
            //            break;
            //        case 2:
            //            $shape = new Triangle($_REQUEST);
            //            break;
            //        case 3:
            //            $shape = new Circle($_REQUEST);
            //            break;
            //    }
            //    echo "Area: ".$shape->area()."<br>";
            //    echo "Parimeter: ".$shape->perimeter()."<br>";
            //}
            echo "<a href=\"page1.php\">page1</a>";
        ?>
    </body>
</html>

