<?php
//TODO: setup mysqli database connector
$_host = 'localhost';
$_username = 'WebServerRoot';
$_password = 'root01';
$_database = 'ENCRYPTED_CHAT';
//creates the Database Connection
$mysql_connection = mysqli($_host,$_username,$_password,$_database);
?>