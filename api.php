<?php

$action = $_POST['action'];

if($action == "sendaction"){
	$company = $_POST['company'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $sex = $_POST['sex'];
}
echo $username.$sex.$email.$tel;
?>