<?php
//TODO: check for session and userId
//current userId 
//$currentUid = $_SESSION['uId'];
$currentUid = "6";
//All includes
include("../Data/messageManager.php");
//gets all headers
$headers=array();
foreach (getallheaders() as $name => $value) {
    $headers[$name] = $value;
}
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
}

?>