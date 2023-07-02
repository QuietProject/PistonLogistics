<?php
session_start();
if (!$_SESSION['passDefault']) {
    header("Location: ./");
}

    $ci = $_SESSION['id'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdRepeat'];

    include "../classes/Db.classes.php";
    include "../classes/Users.classes.php";
    include "../classes/ChangePwd-Contr.classes.php";

    $change = new ChangePwdContr($pwd, $pwdRepeat, $ci);

    $change->changePwd();


    $msg = "success";
    echo json_encode($msg);

