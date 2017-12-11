<?php

include_once 'db_connect.php';

$name = trim($_GET['name']);
$email = trim($_GET['email']);
$message = trim($_GET['message']);

$connection->query("INSERT INTO `comments` VALUES(NULL, '$name', '$email', '$message') ");