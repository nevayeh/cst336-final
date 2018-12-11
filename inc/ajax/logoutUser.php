<?php

session_start();

unset($_SESSION['user']);
$_SESSION['fact'] = $_GET['fact'];

echo json_encode("logged out");

?>