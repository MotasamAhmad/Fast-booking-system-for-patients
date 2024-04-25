<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

include("../connection.php");

$sqlmain = "SELECT * FROM patient WHERE pemail=?";
$stmt = mysqli_prepare($database, $sqlmain);
mysqli_stmt_bind_param($stmt, "s", $useremail);
mysqli_stmt_execute($stmt);
$userrow = mysqli_stmt_get_result($stmt);
$userfetch = mysqli_fetch_assoc($userrow);
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

if ($_GET) {
    include("../connection.php");
    $id = $_GET["id"];

    $sqlmain = "SELECT * FROM patient WHERE pid=?";
    $stmt = mysqli_prepare($database, $sqlmain);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result001 = mysqli_stmt_get_result($stmt);
    $email = (mysqli_fetch_assoc($result001))["pemail"];

    $sqlmain = "DELETE FROM webuser WHERE email=?";
    $stmt = mysqli_prepare($database, $sqlmain);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $sqlmain = "DELETE FROM patient WHERE pemail=?";
    $stmt = mysqli_prepare($database, $sqlmain);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    header("location: ../logout.php");
}
?>
