<?php

//dbConnector
include("dbConnector.php");
function getMessage($userFrom, $userTo){
    $mysql_connection = concection();
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{


        }
        //TODO: Get UserTo messages of each user
        //TODO: merge all Messagelist together
        //TODO: Sort them out by date
}

function createMessage($userFrom, $userTo,$message){
    $mysql_connection = concection();
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
                //setUp Insert Query
    $insertQuery = "INSERT INTO messages (message, fromUser, toUser, timeSend ) values (?, ?, ?, NOW())";
    $insertStmt = $mysql_connection->prepare($insertQuery);
    $insertStmt->bind_param("sss", $message,$userFrom, $userTo);
    $insertStmt->execute();
    $insertStmt->close();
    $mysql_connection ->close();
    return true;


        }
}
?>