<?php
//dbConnector
include("dbConnector.php");

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

?>