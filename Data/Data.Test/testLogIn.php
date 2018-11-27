<?php
//TODO: better test Functions
include("../logInManager.php");
$usrname = 'testUser02';
$frstname = 'pedro';
$lastname = 'winkler';
$eMail = 'go@fuckyourself.com';
$pswrd = 'pussy';
//------creates User
//$result = registerUser($frstname,$lastname,$usrname,password_hash($pswrd, PASSWORD_DEFAULT) , $eMail );
//------check ob den username oder password schon existiert
// $result = checkUserOrEmailExists($usrname,$eMail);
// foreach ($result as $key => $val) {
//     echo $val;
//  }
//------check if user exists Tests returns Boolean
$result = checkUserOrPasswordExists($usrname ,$pswrd );
 foreach ($result as $key => $val) {
     echo $val;
  }
?>