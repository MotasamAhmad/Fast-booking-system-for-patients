<?php

    $database=mysqli_connect("localhost","root","","edoc");
    if (!$database){
        die("Connection failed:  ".$database->connect_error);
    }

?>