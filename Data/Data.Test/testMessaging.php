<?php
include("../messageManager.php");
$result = createMessage(6,7,"HELLO WORLD!");
if($result){
    echo "Successful!";
}

?>