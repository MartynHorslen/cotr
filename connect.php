<?php
//connect.php

// Local
$server = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'CotR';

// Server
// $server = 'localhost';
// $username   = 'martynho';
// $password   = 'M58mfpv1y';
// $database   = 'martynho_CotR';
 
$mysqli = new mysqli($server, $username,  $password);

if(mysqli_connect_errno())
{
    exit('Error: could not establish database connection');
}
if(!mysqli_select_db($mysqli, $database))
{
    exit('Error: could not select the database');
}
?>