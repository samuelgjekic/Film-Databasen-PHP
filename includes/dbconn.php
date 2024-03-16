<?php
// Huvudfil för databasen, vi använder oss av mysqli och hämtar alla parametrar från config.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

$dbconn = mysqli_connect(hostname,username,password,dbname); // Hämta values från config.php 
if ($dbconn->connect_error) {
    exit('Kunde inte ansluta till databas, avbryter script.');
}
