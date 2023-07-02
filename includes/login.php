<?php
session_start();
include "../classes/Db.classes.php";
include "../classes/Users.classes.php";
include "../classes/Login-Contr.classes.php";
$login = new LoginContr($usuario,$pwd);

$login->login();
echo json_encode('success');
