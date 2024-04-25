
    <?php
    
    include("../connection.php");


    if ($_POST) {
        //print_r($_POST);
        $result = mysqli_query($database, "SELECT * FROM webuser");
        $name = $_POST['name'];
        $oldemail = $_POST["oldemail"];
        $nic = $_POST['nic'];
        $spec = $_POST['spec'];
        $email = $_POST['email'];
        $tele = $_POST['Tele'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $id = $_POST['id00'];
    
        if ($password == $cpassword) {
            $error = '3';
            $result = mysqli_query($database, "SELECT doctor.docid FROM doctor INNER JOIN webuser ON doctor.docemail = webuser.email WHERE webuser.email = '$email';");
    
            if (mysqli_num_rows($result) == 1) {
                $id2 = mysqli_fetch_assoc($result)["docid"];
            } else {
                $id2 = $id;
            }
    
            echo $id2 . "jdfjdfdh";
    
            if ($id2 != $id) {
                $error = '1';
            } else {
                $sql1 = "UPDATE doctor SET docemail='$email', docname='$name', docpassword='$password', docnic='$nic', doctel='$tele', specialties=$spec WHERE docid=$id;";
                mysqli_query($database, $sql1);
    
                $sql1 = "UPDATE webuser SET email='$email' WHERE email='$oldemail';";
                mysqli_query($database, $sql1);
    
                echo $sql1;
                //echo $sql2;
                $error = '4';
            }
    
        } else {
            $error = '2';
        }
    } else {
        //header('location: signup.php');
        $error = '3';
    }
    
    

    header("location: settings.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>