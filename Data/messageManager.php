<?php

//dbConnector
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
            $selectQuery = "Select messages.mId,messages.message,u1.userName as fromUser,u2.userName as toUser,messages.fromUser as frmUsrId,messages.toUser as tUsrId,messages.timeSend, messages.isEdited FROM messages  INNER JOIN users u1 ON messages.fromUser = u1.uId INNER JOIN users u2 ON messages.toUser = u2.uId where  ((fromUser = ? && toUser = ?)||(fromUser = ? && toUser = ?)) && (isDeleted = 0) ORDER BY messages.timeSend ASC limit 10;";
            $selectStmt = $mysql_connection->prepare($selectQuery);
            $selectStmt->bind_param("ssss",$userFrom,$userTo, $userTo,$userFrom);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            
            if($result->num_rows !== 0){
                
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $messageQuery['mId'] = $row['mId'];
                    $messageQuery['message'] = $row['message'];
                    $messageQuery['fromUser'] = $row['fromUser'];
                    $messageQuery['toUser'] = $row['toUser'];
                    $messageQuery['timeSend'] = $row['timeSend'];
                    $messageQuery['fromUserId'] = $row['frmUsrId'];
                    $messageQuery['toUserId'] = $row['tUsrId'];
                    $messageQuery['isEdited'] = $row['isEdited'];
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

function changeMessage($messageCreator,$mId,$newMessage){
    //TODO: implement method
    $messageChanged = false;
    $mysql_connection = concection();
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
            $checkMessageCreatorQuery = "SELECT * FROM messages where mId = ? && fromUser = ?";
            $checkStmt = $mysql_connection->prepare($checkMessageCreatorQuery);
            $checkStmt->bind_param("ss", $mId,$messageCreator);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            if($result->num_rows !== 0){
            $changeMsgQuery = "UPDATE messages SET message = ?, isEdited = 1 where mId = ? && fromUser = ?";
            $cahngeMsgStmt = $mysql_connection->prepare($changeMsgQuery);
            $cahngeMsgStmt->bind_param("sss", $newMessage,$mId,$messageCreator);
            $cahngeMsgStmt->execute();
            $cahngeMsgStmt->close();
            $mysql_connection ->close();
            $messageChanged = true;
        }else{
            $messageChanged = false;
        }
        $checkStmt->close();
        return $messageChanged;
        }
}
function deleteMessage($messageCreator,$mId){
    //TODO: implemnet method
    //Only delete message whom the creator created
    $messageDeleted = false;
    $mysql_connection = concection();
    if ($mysql_connection->connect_error) {
        die("Connection failed: " . $mysql_connection->connect_error);
        return false;
        }else{
            $checkMessageCreatorQuery = "SELECT * FROM messages where mId = ? && fromUser = ?";
            $checkStmt = $mysql_connection->prepare($checkMessageCreatorQuery);
            $checkStmt->bind_param("ss", $mId,$messageCreator);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            if($result->num_rows !== 0){
            $deleteMsgQuery = "UPDATE messages SET isDeleted = 1 where mId = ? && fromUser = ?";
            $deleteStmt = $mysql_connection->prepare($deleteMsgQuery);
            $deleteStmt->bind_param("ss", $mId,$messageCreator);
            $deleteStmt->execute();
            $deleteStmt->close();
            $mysql_connection ->close();
            $messageDeleted = true;
        }else{
            $messageDeleted = false;
        }
        $checkStmt->close();
        return $messageDeleted;
        }
}
?>