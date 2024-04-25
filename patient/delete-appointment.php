<?php

session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_GET) {

    include("../connection.php");
    $id = $_GET["id"];
    
    $sqlmain = "DELETE FROM appointment WHERE appoid=?";
    $stmt = mysqli_prepare($database, $sqlmain);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("location: appointment.php");
}

?>
