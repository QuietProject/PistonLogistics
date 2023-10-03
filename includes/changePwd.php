<?php
session_start();
if (!isset($_SESSION['id'])) {
    exit;
}

if (!$_SESSION['passDefault']) {
    exit;
}

    $ci = $_SESSION['id'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdRepeat'];

    require "../classes/Db.classes.php";
    require "../classes/Users.classes.php";
    require "../classes/ChangePwd-Contr.classes.php";

    $change = new ChangePwdContr($pwd, $pwdRepeat, $ci);

    $change->changePwd();


    $msg = "success";
    echo json_encode($msg);

