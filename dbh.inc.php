<?php

$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "anime";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>


