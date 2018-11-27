<?php
//TODO: setup mysqli database connector
function concection(){
    $_host = 'localhost';
    $_username = 'WebServerRoot';
    $_password = 'root01';
    $_database = 'ENCRYPTED_CHAT';
    //creates the Database Connection
     return new mysqli($_host,$_username,$_password,$_database);
}

?>