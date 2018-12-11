<?php
//check for session and userId


//All includes
include("../Data/messageManager.php");
//gets all headers
$headers=array();
foreach (getallheaders() as $name => $value) {
    $headers[$name] = $value;
}

switch ($headers['FUNCTION']) {
    case "SEND_MESSAGE":
        
        $res = createMessage('6',$headers['VAL01'],$headers['VAL02']);
        var_dump($res);
        break;

        case "GET_MESSAGES":
        $res = getMessage('6',$headers['VAL01']);
        echo json_encode(array_filter($res));
        break;
    
    default:
        echo "ERROR";
        break;
}
?>