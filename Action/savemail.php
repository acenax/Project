<?php
require('../Controller/connect.php');
$email_check = "SELECT * FROM tbluser WHERE user_email = '" . $_POST['email'] . "'";
$res = mysqli_query($con, $email_check);
if (mysqli_num_rows($res) > 0) {
    // ถ้าเจอ
    //สุ่มรหัส

    $n = 5;
    function getRandomString($n)
    {
        $characters = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    $forgot_key = getRandomString($n);

    $rows_data = $res->fetch_assoc();
    // echo  $rows_data['user_id'];
    print_r($_POST);
    $_POST['check-email'] = '1';

    //บันทึกลงตารางชื่อ savemail
    $sq = date('Y-m-d H:i:s');
    $key_expire = date('Y-m-d H:i:s', strtotime('+35 minutes', strtotime($sq)));
    $insert_savemail = "INSERT INTO tblsavemail VALUES ('', '" . $_POST['email'] . "', '" . $forgot_key . "', '" . $key_expire . "')";
    mysqli_query($con, $insert_savemail);

    //if user click continue button in forgot password form
    
    if (isset($_POST['check-email'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $check_email = "SELECT * FROM tbluser WHERE user_email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if (mysqli_num_rows($run_sql) > 0) {
            $code = rand(999999, 111111);
            $md5Code = md5($code);
            $insert_code = "UPDATE tbluser SET user_password = '".$md5Code."', user_Real_password = $code WHERE user_email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if ($run_query) {
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: popc2202@gmail.com";
                if (mail($email, $subject, $message, $sender)) {
                    $info = "We've sent a passwrod reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: ../View/login_register/reset-code.php');
                    exit();
                } else {
                    $errors['otp-error'] = "Failed while sending code!";
                }
            } else {
                $errors['db-error'] = "Something went wrong!";
            }
        } else {
            $errors['email'] = "This email address does not exist!";
        }
    }

    //ส่งอีเมล

    //ถ้าไม่เจอ
}
