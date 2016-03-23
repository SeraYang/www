<html>
    <head>
        <p> this is index page </p>
    </head>

    <body>
        <form>
            <b> First name </b>
            <input type="text" name="fname"/> <br>
            <b> Last name </b>
            <input type="text" name="lname"/> <br>
            <b> User Name </b>
            <input type="text" name="username"/> <br>
            <b> Password </b>
            <input type="text" name="password"/> <br>
            <b> Location </b>
            <input type="text" name="location"/> <br>
            <b> contect </b>
            <input type="text" name="contact"/> <br>
        </form>
        <?php
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

            $email = "yang@hofstra.com.edu";
            print tablename($email);
        ?>
    </body>
</html>
