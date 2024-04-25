<?php
session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" or $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_GET) {

    include("../connection.php");

    $id = $_GET["id"];
    $result001 = mysqli_query($database, "SELECT * FROM doctor WHERE docid=$id");
    $email = mysqli_fetch_assoc($result001)["docemail"];
    $sql = mysqli_query($database, "DELETE FROM webuser WHERE email='$email'");
    $sql = mysqli_query($database, "DELETE FROM doctor WHERE docemail='$email'");
    header("location: doctors.php");
}
?>
