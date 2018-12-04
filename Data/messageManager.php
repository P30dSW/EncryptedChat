<?php

//dbConnector
include("dbConnector.php");
function getMessage($userFrom, $userTo){
    $firstTenMessages[] = null;
    $mysql_connection = concection();
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
            //get first messages
            //Order by timeSend Limit 10
            //JOIN for the Username instead of Id
            $selectQuery = "Select messages.message,u1.userName as fromUser,u2.userName as toUser,messages.fromUser as frmUsrId,messages.toUser as tUsrId,messages.timeSend FROM messages  INNER JOIN users u1 ON messages.fromUser = u1.uId INNER JOIN users u2 ON messages.toUser = u2.uId where (fromUser = ? || ?) && (toUser = ? || ?) ORDER BY messages.timeSend DESC limit 10;";
            $selectStmt = $mysql_connection->prepare($selectQuery);
            $selectStmt->bind_param("ssss",$userFrom,$userTo, $userFrom,$userTo);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            
            if($result->num_rows !== 0){
                
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    
                    $messageQuery['message'] = $row['message'];
                    $messageQuery['fromUser'] = $row['fromUser'];
                    $messageQuery['toUser'] = $row['toUser'];
                    $messageQuery['timeSend'] = $row['timeSend'];
                    $messageQuery['fromUserId'] = $row['frmUsrId'];
                    $messageQuery['toUserId'] = $row['tUsrId'];
                    array_push($firstTenMessages, $messageQuery);
                }
            }
        }
        $selectStmt->close();
    $mysql_connection ->close();
        //TODO: Get UserTo messages of each user (where frouser = user1 && user2 usw...)
         return $firstTenMessages;
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