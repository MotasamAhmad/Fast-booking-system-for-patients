<?php
    
    include("../connection.php");

    if ($_POST) {
        //print_r($_POST);
        $result = mysqli_query($database, "SELECT * FROM webuser");
        $name = $_POST['name'];
        $nic = $_POST['nic'];
        $oldemail = $_POST["oldemail"];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $tele = $_POST['Tele'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $id = $_POST['id00'];

        if ($password == $cpassword) {
            $error = '3';

            $sqlmain = "SELECT patient.pid FROM patient INNER JOIN webuser ON patient.pemail=webuser.email WHERE webuser.email=?";
            $stmt = mysqli_prepare($database, $sqlmain);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $id2 = mysqli_fetch_assoc($result)["pid"];
            } else {
                $id2 = $id;
            }

            if ($id2 != $id) {
                $error = '1';
            } else {
                $sql1 = "UPDATE patient SET pemail='$email', pname='$name', ppassword='$password', pnic='$nic', ptel='$tele', paddress='$address' WHERE pid=$id";
                mysqli_query($database, $sql1);

                $sql1 = "UPDATE webuser SET email='$email' WHERE email='$oldemail'";
                mysqli_query($database, $sql1);

                $error = '4';
            }
        } else {
            $error = '2';
        }
    } else {
        $error = '3';
    }

    header("location: settings.php?action=edit&error=" . $error . "&id=" . $id);

?>
