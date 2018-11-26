<?php

//dbConnector
include("dbConnector.php");

//Register Method
function registerUser($_firstname,$_lastname,$_username,$_password,$_email){
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
    //setUp Insert Query
    $insertQuery = "INSERT INTO users (firstName, lastName, userName, eMail, password ) values (?, ?, ?, ?, ?)";
    $insertStmt = $mysql_connection->prepare($insertQuery);
    $insertStmt->bind_param("sssss", $_firstname, $_lastname, $_username, $_password, $_email);
    $insertStmt->execute();
    $insertStmt->close();
    $mysql_connection ->close();
    return true;
}}
//only for register
function checkUserOrEmailExists($_username,$_email){
    $usernameExists = false;
    $eMailExists = false;
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
            //checkquery wird erstellt
            $checkQuery = "SELECT * from users where userName = ?";
            $checkStmt = $mysql_connection->prepare($checkQuery);
		    //binding usercheck and executing it
            $checkStmt->bind_param("s",$_username);
            $checkStmt->execute();
            //getting result
            $result = $checkStmt->get_result();
            if($results->num_rows !== 0){
                $usernameExists = true;
            }
            $checkStmt->close();
            $mysql_connection ->close();
            //checkquery wird erstellt
            $checkQuery = "SELECT * from users where eMail = ?";
            $checkStmt = $mysql_connection->prepare($checkQuery);
		    //binding usercheck and executing it
            $checkStmt->bind_param("s",$_email);
            $checkStmt->execute();
            //getting result
            $result = $checkStmt->get_result();
            if($results->num_rows !== 0){
                $eMailExists = true;
            }
            $checkStmt->close();
            $mysql_connection ->close();
        }
        return [ $usernameExists,$eMailExists];
}

function checkUserOrPasswordExists($_username,$_password){
    
    $logInIsTrue = false;
    $pw = "";
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
            //checkquery wird erstellt
            $checkQuery = "SELECT password from users where userName = ?";
            $checkStmt = $mysql_connection->prepare($checkQuery);
		    //binding usercheck and executing it
            $checkStmt->bind_param("s",$_username);
            $checkStmt->execute();
            //getting result
            $result = $checkStmt->get_result();
            //see if the user corresponds with the parameter
            if (mysqli_num_rows($result) > 0) {
               
                while($row = mysqli_fetch_assoc($result)) {
                    $pw = $row["password"];
                }
                if(password_verify($_password,$pw)){
                    $logInIsTrue = true;
                }
            }
            $checkStmt->close();
            $mysql_connection ->close();
        }
        return $logInIsTrue;
}

?>