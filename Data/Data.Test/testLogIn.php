<?php
include("logInManager.php");
$usrname = 'testUser01';
$frstname = 'pedro';
$lastname = 'winkler';
$eMail = 'go@fuckyourself.com';
$pswrd = 'pussy';
$result = registerUser($frstname,$lastname,$usrname,$pswrd,$_email );
echo $result;
?>