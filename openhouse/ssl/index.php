<html>
    <head>
        <title></title>
        <?php

        ?>
    </head>

    <body>
        <?php

            $servername = "localhost"; // where is the server
            $username = "openhouse";
            $password = "test";
            $dbname = "ohDB";

            //Create connection
            $conn = new mysqli($servername, 
                                $username,
                                $password,
                                $dbname);

            //Check connection
            if($conn -> connect_error){
                die("Connection failed: " . 
                    $conn->connect_error);
            }

            $sql_insert = "INSERT INTO MyGuests (firstname,lastname,email)
                VALUES ('John','Doe','john@example.com')";

            $sql_create = "create table MyGuests(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    firstname VARCHAR(30) NOT NULL,
                    lastname VARCHAR(30) NULL NULL,
                    email VARCHAR(50),
                    reg_date TIMESTAMP
                )";
            //if($conn -> query($sql_create)===TRUE){
            //    echo"Table MyGuests created successfully<br>";
            //}else{
            //    echo "Error creating table: <br>". $conn->error;
            //}

            if($conn -> query($sql_insert) == TRUE){
                echo "New record created successfully<br>";
            } else{
                echo "Error: ".$sql_insert."<br>".$conn->error;
            }

            $conn -> close();
        ?>
    </body>
</html>

