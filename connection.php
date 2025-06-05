<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "cils"; //change to product_selling if ayos n

//gawa connection
$conn = new mysqli($server, $username, $password, $database);
//check yung connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


