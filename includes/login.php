<?php
session_start();
$usuario = $_POST['usuario'];
$pwd = $_POST['pwd'];

require "../classes/Db.classes.php";
require "../classes/Users.classes.php";
require "../classes/Login-Contr.classes.php";
$login = new LoginContr($usuario, $pwd);

$login->login();
echo json_encode('success');
