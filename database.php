<?php
// connect to our mysql database server
function getDatabaseConnection() {
    if (strpos($_SERVER['SERVER_NAME'], "c9users") !== false) {
        // running on cloud9
        $host = "localhost";
        $username = "jon";
        $password = "cst336"; // best practice: define this in a separte file
        $dbname = "Final"; 
    } else {
       //running on Heroku
        $host = "us-cdbr-iron-east-01.cleardb.net";
        $username = "be99cecc0350fe";
        $password = "5e6dcebf"; // best practice: define this in a seperate file
        $dbname = "heroku_67c7533a3466144"; 
    }
    
    
    // Create connection
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConn; 
}
// temporary test code
//$dbConn = getDatabaseConnection(); 
?>
