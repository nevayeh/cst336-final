<?php

session_start();

include_once '../../api/spoonacularAPI.php';

$foodFact = foodFact();
$_SESSION['fact'] = $foodFact['fact'];

echo json_encode($foodFact['fact']);

?>