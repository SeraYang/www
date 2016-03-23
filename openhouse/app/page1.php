<html>
    <head>
        <title></title>
        <?php
            echo "this is the first line. <br>";
            echo "<p> this is the second line. </p><br>";
            echo "<b> this is the third line. </b><br>";
            echo nl2br("One line. \n Another line.\n");
            echo "&amp; &quot; &#039;"; echo "<br/>";
            
            echo htmlentities("< > ' \" ")."<br />";
        ?>
    </head>

    <body>
        <form action="" method="post">
            Input a string:
            
        </form>
        <?php


        ?>
    </body>
</html>

