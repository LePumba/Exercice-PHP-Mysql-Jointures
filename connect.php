<?php
$servername = "localhost";
$username = "pumba";
$password = 'pumbaSQL';
$dbname = "upto";

$conn = new Mysqli($servername,$username,$password) or die("Aucune connexion");

if ($conn->connect_error)
{
    echo $conn->connect_error;
}else {
    $conn->select_db($dbname);
}