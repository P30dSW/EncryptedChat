<?php
//dbConnector

function getListOfAllUsers(){
$usrList[] = null;
//define Connection
$mysql_connection = concection();
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
    return false;
    }else{
    //setUp Insert Query
    $usersQuery = "SELECT uId,userName FROM users;";

    $userStmt = $mysql_connection->prepare($usersQuery);
    $userStmt->execute();

    $res = $userStmt->get_result();
    if ($res->num_rows > 0) {
    while($row = $res->fetch_array(MYSQLI_ASSOC)) {
        
        $user['uId'] = $row['uId'];
        $user['userName'] = $row['userName'];
        array_push($usrList,$user);
    }
}
    $userStmt->close();
    $mysql_connection ->close();
    return $usrList;

}
}

function getImageNameFromUid($uId){
    //TODO:Implement
    $profileName = "";
    $mysql_connection = concection();
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
    return false;
    }else{
    $selectQuery = "SELECT profilePicName FROM users WHERE uId = ?";
    $selectStmt = $mysql_connection->prepare($selectQuery);
    $selectStmt->bind_param("s",$uId);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
            //see if the user corresponds with the parameter
            if ($result->num_rows > 0) {
               
                while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $profileName = $row["profilePicName"];
                }
            }
            $selectStmt->close();
            $mysql_connection ->close();

    }
    return $profileName;
}
?>