<?php
/* Här har jag skapat en config med pre defined strings så jag slipper skriva dom på olika sidor
om jag nu gör flera sidor. Denna fil inkluderas på alla sidor så att man inte behöver skriva allt om och om igen. */


// Sidans olika element
define('pageauthor','Samuel Gjekic');
define('pagetitle','Film Databasen av' . ' ' . pageauthor);


// Databas Konfiguration
define('hostname','localhost');
define('username','admin');
define('password','password');
define('dbname','testdb001');
define('dbconn', $_SERVER['DOCUMENT_ROOT'] . '/includes/dbconn.php');
