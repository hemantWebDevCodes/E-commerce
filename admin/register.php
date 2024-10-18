<?php

include "database.php";

$obj = new Database();

if (isset($_POST['email'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $obj->select('user_registration', '*', null, "email='$email'", null, null);
    $check = $obj->getResult();

    if ($check) {
        echo "data_Already_exit";
    } else {
        $value = ['name' => $name, 'email' => $email, 'register_mobile' => $mobile, 'password' => $password];
        $register = $obj->insert('user_registration', $value);

        echo "success";
    }
}

//Login Code Data

if (isset($_POST['login_email']) && isset($_POST['login_password'])) {
    $username = isset($_POST['login_email']) ? $_POST['login_email'] : '';
    $password = isset($_POST['login_password']) ? $_POST['login_password'] : '';

    $condition = "email='$username' AND password ='$password'";

    $obj->select('user_registration', 'email,password,id', null, $condition, null, null);
    $result = $obj->getResult();

    if ($result) {
        session_start();
        $_SESSION['email'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['id'] = $result[0]['id'];

        echo "login";
    }
}
?>
