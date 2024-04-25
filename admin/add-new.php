<?php
include("../connection.php");

session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" or $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_POST) {
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $spec = $_POST['spec'];
    $email = $_POST['email'];
    $tele = $_POST['Tele'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $target = "../img/doc/";
    $target = $target.basename($_FILES['profile_image']['name']);
    $profileImagePath = ($_FILES['profile_image']['name']);

    if ($password == $cpassword) {
        $error = '3';
        $result = mysqli_query($database, "SELECT * FROM webuser WHERE email='$email'");

        if (mysqli_num_rows($result) == 1) {
            $error = '1'; // البريد الإلكتروني مستخدم مسبقًا
        } else {
            $sql1 = "INSERT INTO doctor (docemail, docname, docpassword, docnic, doctel, specialties, doctor_img_path) VALUES ('$email', '$name', '$password', '$nic', '$tele', $spec, '$profileImagePath')";
            $sql2 = "INSERT INTO webuser VALUES ('$email', 'd')";
            $sql3 = move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);

            mysqli_query($database, $sql1);
            mysqli_query($database, $sql2);
            mysqli_query($database, $sql3);

            $error = '4'; // تم التحديث بنجاح
        }
    } else {
        $error = '2'; // عدم تطابق كلمة المرور
    }
} else {
    $error = '3'; // عدم استلام البيانات بشكل صحيح
}

header("location: doctors.php?action=add&error=".$error);
?>