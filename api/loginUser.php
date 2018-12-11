<?php

session_start();

$_SESSION['user'] = $_GET['username'];
$_SESSION['fact'] = $_GET['fact'];

echo json_encode("logged in");

?>

