<html>
    <head>
    </head>

    <body>
        <form>
            <b> First name </b>
            <input type="text" name="fname"/><br>
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
            echo "\n".'Yang Pang';
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
//             $testarr = array('yang',array('this','is','my','name'),'fan');
			$testarr = array();
			$testarr['first'] = 'firstname';
			$testarr['middle'] = 'Middle Name';
			$testarr['tail'] = array('tail1'=>0,'tail2'=>1,'tail3'=>2);
            echo json_encode($testarr);
//             $xx = 'null';
//             if($email){
//             	$xx = 'true';
//             }else{
//             	$xx = 'false';
//             }
//             echo '<br>'.$xx;
			echo '<br>';
            //print tablename($email);
            $conn = new PDO("mysql:host=localhost;dbname=ohDB_AGENT",'root','Yang123');
//             foreach($conn -> query('SELECT * from user;') as $result){
//             	//echo $result.'<br>';
//             	foreach($result as $key=>$row){
//             		echo $key.'-----'.$row;
//             		echo '<br>';
//             	}
// // 				echo $result[0].'<br>';
// // 				echo $result{'fName'}.'<br>';
//             }

            $arr = $conn -> query('SELECT * FROM user;');
            $result = $arr -> fetch(PDO::FETCH_ASSOC);
//             echo $result;
            print_r($result);
        ?>
    </body>
</html>
