
    <?php
    
    // استيراد قاعدة البيانات
    include("../connection.php");
    
    if ($_POST) {
        // استلام البيانات من النموذج
        $name = $_POST['name'];
        $nic = $_POST['nic'];
        $oldemail = $_POST["oldemail"];
        $spec = $_POST['spec'];
        $email = $_POST['email'];
        $tele = $_POST['Tele'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $id = $_POST['id00'];
    
        // التحقق من تطابق كلمة المرور
        if ($password == $cpassword) {
            $error = '3';
    
            // التحقق من تكرار البريد الإلكتروني الجديد
            $result = $database->query("SELECT docid FROM doctor WHERE docemail='$email' AND docid != '$id'");
            if ($result->num_rows == 1) {
                $error = '1'; // البريد الإلكتروني مستخدم مسبقًا
            } else {
                // تحديث بيانات الدكتور
                $sqlUpdateDoctor = "UPDATE doctor SET docemail='$email', docname='$name', docpassword='$password', docnic='$nic', doctel='$tele', specialties=$spec WHERE docid=$id";
                $database->query($sqlUpdateDoctor);
    
                // التحقق من تحديث الصورة
                if ($_FILES['profile_image']['error'] === 0) {
                    $target = "../img/doc/";
                    $profileImagePath = $_FILES['profile_image']['name'];
                    move_uploaded_file($_FILES['profile_image']['tmp_name'], $target . $profileImagePath);
    
                    // تحديث مسار الصورة في قاعدة البيانات
                    $sqlUpdateImage = "UPDATE doctor SET doctor_img_path='$profileImagePath' WHERE docid='$id'";
                    $database->query($sqlUpdateImage);
                }
    
                $error = '4'; // تم التحديث بنجاح
            }
        } else {
            $error = '2'; // عدم تطابق كلمة المرور
        }
    } else {
        $error = '3'; // عدم استلام البيانات بشكل صحيح
    }
    
    // إعادة توجيه إلى صفحة التحرير مع معرف الدكتور ورمز الخطأ
    header("location: doctors.php?action=edit&error=$error&id=$id");
    ?>
    
   

</body>
</html>