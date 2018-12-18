<?php

//dbConnector
include("dbConnector.php");

//Register Method (does NOT Hash the password!!!!)
function registerUser($_firstname,$_lastname,$_username,$_password,$_email,$_profileImg){
    //define Connection
    $mysql_connection = concection();
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
    //setUp Insert Query
    $insertQuery = "";
    $insertStmt = null;
    if($_profileImg != null){
        $imgName = addProfilePicture($_profileImg);
        $insertQuery = "INSERT INTO users (firstName, lastName, userName, eMail, password ,profilePicName) values (?, ?, ?, ?, ?, ?)";
        $insertStmt = $mysql_connection->prepare($insertQuery);
        $insertStmt->bind_param("ssssss", $_firstname, $_lastname, $_username, $_email,$_password,$imgName);
    }else{
        $imgName  = "dummy_profile.png";
        $insertQuery = "INSERT INTO users (firstName, lastName, userName, eMail, password,profilePicName ) values (?, ?, ?, ?, ?, ?)";
        $insertStmt = $mysql_connection->prepare($insertQuery);
        $insertStmt->bind_param("ssssss", $_firstname, $_lastname, $_username, $_email,$_password,$imgName );
    }
    
    $insertStmt->execute();
    $insertStmt->close();
    $mysql_connection ->close();
    //TODO: return UserId
    return checkUserOrPasswordExists($_username,$_password);
}}
//only for register
function checkUserOrEmailExists($_username,$_email){
    $mysql_connection = concection();
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
            if($result->num_rows !== 0){
                $usernameExists = true;
            }
            //checkquery wird erstellt
            $checkQuery = "SELECT * from users where eMail = ?";
            $checkStmt = $mysql_connection->prepare($checkQuery);
		    //binding usercheck and executing it
            $checkStmt->bind_param("s",$_email);
            $checkStmt->execute();
            //getting result
            $result = $checkStmt->get_result();
            if($result->num_rows !== 0){
                $eMailExists = true;
            }
            $checkStmt->close();
            $mysql_connection ->close();
        }
        return [ $usernameExists,$eMailExists];
}

function checkUserOrPasswordExists($_username,$_password){
    $mysql_connection = concection();
    $logInIsTrue = false;
    $pw = "";
    $uid = "NOUID";
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
            //checkquery wird erstellt
            $checkQuery = "SELECT password, uId from users where userName = ?";
            $checkStmt = $mysql_connection->prepare($checkQuery);
		    //binding usercheck and executing it
            $checkStmt->bind_param("s",$_username);
            $checkStmt->execute();
            //getting result
            $result = $checkStmt->get_result();
            //see if the user corresponds with the parameter
            if ($result->num_rows > 0) {
               
                while($row = mysqli_fetch_assoc($result)) {
                    $pw = $row["password"];
                    $uid = $row["uId"];
                }
                if(password_verify($_password,$pw)){
                    $logInIsTrue = true;
                   
                }
            }
            $checkStmt->close();
            $mysql_connection ->close();
        }
        return [$uid, $logInIsTrue];
}


function changePassword($uid,$firstPw,$newPwHash){
    $pw = "";
    $mysql_connection = concection();
    $passwordChanged = false;
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
    $checkPwQurey ="SELECT password FROM USERS WHERE uId = ?";
    $checkPwStmt = $mysql_connection->prepare($checkPwQurey);
  
    $checkPwStmt->bind_param("s",$uid);
    $checkPwStmt->execute();
    $checkResult =  $checkPwStmt->get_result();
    if ($checkResult->num_rows > 0) {
        while($row = mysqli_fetch_assoc($checkResult)) {
            $pw = $row["password"];
            
        }
        if(password_verify($firstPw,$pw)){
            //Second connection
            $changePwQuery ="UPDATE USERS SET password = ? where uId = ?";
            $changePwStmt =  $mysql_connection->prepare($changePwQuery);
            $changePwStmt->bind_param("si",$newPwHash,$uid);
            $changePwStmt->execute();
            $passwordChanged = true;
        }
    }
}
return $passwordChanged;
}

function changeUserName($uid,$newUsername){
    
    $userNameChanged = false;
    $mysql_connection = concection();
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
            //Query
            $changeUnQuery = "UPDATE USERS SET userName = ? where uId = ?";
            $changeUnStmt =  $mysql_connection->prepare($changeUnQuery);
            $changeUnStmt->bind_param("si",$newUsername,$uid);
            $changeUnStmt->execute();
            $userNameChanged = true;
        }
        return $userNameChanged;
}

function addProfilePicture($img_file){
    //TODO: Implement method

    $profilePicName = "";
    //check fileType
    $fileExt = explode('.',$img_file['name']);
    $fileAcExt = strtolower(end($fileExt));
    $allowed = array('jpg','jpeg','png');
    // 
    //generate uid
    if(in_array($fileAcExt,$allowed)){
        $newImgName = uniqid('',true);
        $newDicretory = "../src/Profile_Pictures/" . $newImgName . "." . $fileAcExt;
        move_uploaded_file($img_file['tmp_name'],$newDicretory);
        $profilePicName = $newImgName . "." . $fileAcExt;
    }
    
    return $profilePicName;
}
?>