<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['uname']) && isset($_SESSION['password']) && isset($_SESSION['name']) && isset($_SESSION['re_password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    $name = validate($_POST['name']);
    $re_pass = validate($_POST['re_password']);

    $user_data = 'uname'. $uname. '$name'. $name;


    if (empty($uname)) {
        header("Location: signup.php?error=User Name is required&$user_data"); #name ว่าง
        exit();
    }
    else if (empty($pass)) {
        header("Location: signup.php?error=Password is required&$user_data"); #pass ว่าง
        exit();
    }
    else if (empty($re_pass)) {
        header("Location: signup.php?error=Re Password is required&$user_data"); #re_pass ว่าง
        exit();
    }
    else if (empty($name)) {
        header("Location: signup.php?error=Name is required&$user_data"); #nameว่าง
        exit();
    }
    else if ($pass !== $re_pass) {
        header("Location: signup.php?error=The confirmation password does not match&$user_data");
        exit();
    }
    else{
        $pass = md5($pass);
        $sql= "SELECT * FROM users WHERE user_name='$uname' ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
                $row (mysqli_fetch_assoc($result));
                header("Location: signup.php?error=The username is taken try another&$user_data");
                exit();
        }
        else{
            $sql2 = "INSERT INTO users(user_name, password, name) VALUES9('$uname', '$pass', '$name')";
            $result2 = mysqli_query($conn, $sql);

        if ($result2) {
            header("Location: login.php?success=Your account has been created successfully");
            exit();
        }
        else {
            header("Location: login.php?error=Unknown error ocurred$user_data");
            exit(); 
        }
            }
    }

}else{
    header("Location: signup.php");
    exit();
}
?>