<?php
// connect to our mysql database server
function getDatabaseConnection()
{
    //Neva's localhost (here for testing)
    if (strpos($_SERVER['SERVER_NAME'], "nevayeh.c9users") !== false) {
        // running on cloud9
        $host = "localhost";
        $username = "nyeh";
        $password = "Admin"; // best practice: define this in a separte file
        $dbname = "final"; 
    } 
    //Jerry's localhost
    else if (strpos($_SERVER['SERVER_NAME'], "galcaraz") !== false) {
        // running on cloud9
        $host = "localhost";
        $username = "Jerry";
        $password = "BabaBooey1"; // best practice: define this in a separte file
        $dbname = "final"; 
    } 
    else if (strpos($_SERVER['SERVER_NAME'], "c9users") !== false) {
        // running on cloud9
        $host = "localhost";
        $username = "jon";
        $password = "cst336"; // best practice: define this in a separte file
        $dbname = "final"; 
    } 
    //Neva's Heroku DB
    else if(strpos($_SERVER['SERVER_NAME'], 'cst336-nevayeh-final') !== false)
    {
       //running on Heroku
        $host = "us-cdbr-iron-east-01.cleardb.net";
        $username = "b5a706b2943846";
        $password = "6db517db"; // best practice: define this in a seperate file
        $dbname = "heroku_74832e9767c0d39";
    }
    else {
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
