<?php
//TODO: check for session and userId
//current userId 

//$currentUid = "6";
//All includes
include("../Data/dbConnector.php");
include("../Data/messageManager.php");
//gets all headers
$headers=array();
foreach (getallheaders() as $name => $value) {
    $headers[$name] = $value;
}
if(isset($headers['SESSION_ID'])){
    session_id($headers['SESSION_ID']);
    session_start();
    $currentUid = $_SESSION['uId'];

if(isset($headers['FUNCTION'])){
    switch ($headers['FUNCTION']) {
        case "SEND_MESSAGE":
            
            $res = createMessage($currentUid,htmlspecialchars(trim($headers['VAL01'])),htmlspecialchars(trim($headers['VAL02'])));
            echo $res;
            break;
    
            case "GET_MESSAGES":
            $res = getMessage($currentUid,htmlspecialchars(trim($headers['VAL01'])));
            echo json_encode(array_filter($res));
            break;
    
            case "DELETE_MESSAGE":
            $res = deleteMessage($currentUid,htmlspecialchars(trim($headers['VAL01'])));
            echo $res;
            break;
    
            case "CHANGE_MESSAGE":
            $res = changeMessage($currentUid,htmlspecialchars(trim($headers['VAL01'])),htmlspecialchars(trim($headers['VAL02'])));
            echo $res;
            break;
        
            default:
            echo "ERROR: NO VALID FUNCTION SELECTED";
            break;
    }
}else{
    echo "NO FUNCTION SELECTED";
}
}else{
    echo "NO VALID SESSION ID";
}

?>