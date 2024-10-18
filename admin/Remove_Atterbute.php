<?php

include "database.php";

$obj = new Database();

if (isset($_POST['id'])) {
    if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
    } else {
        echo "<script>location.window.href='login-registration.php';</script>";
    }

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $obj->delete('product_attribute', "id='$id'");
}

?>
