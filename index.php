<?php
require 'connect.php';

$liste = "SELECT * FROM eleves";

$result = $conn->query($liste);

while($row = $result->fetch_assoc())
{
    echo "<br>" . $row['nom'] . " " . $row['prenom'] . " <a href='index2.php?id=".$row['id']."'>+</a><br>";
}





