<?php
// Inloggen op database en database selecteren
define("SERVERNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASENAME", "bmi");

// Contact maken met MySQL-Server
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASENAME);
?>