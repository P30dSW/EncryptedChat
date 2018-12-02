<?php
//TODO: better test Functions
include("../logInManager.php");
$usrname = 'testUser02';
$frstname = 'pedro';
$lastname = 'winkler';
$eMail = 'go@fuckyourself.com';
$pswrd = 'pussy';
$newPw = "newPassword01";
//------creates User
$prevHash = password_hash($pswrd, PASSWORD_DEFAULT);
$uId = registerUser($frstname,$lastname,$usrname, $prevHash , $eMail )[0];
echo $uId;
echo "</br>" . $prevHash ."</br>";
//------check ob den username oder password schon existiert
// $result = checkUserOrEmailExists($usrname,$eMail);
// foreach ($result as $key => $val) {
//     echo $val;
//  }
//------check if user exists Tests returns Boolean
// $result = checkUserOrPasswordExists($usrname ,$pswrd );
//  foreach ($result as $key => $val) {
//      echo $val;
//   }

  //------change password of existing user
  echo "Test Case:changing Password";
$pwChangeResult =  changePassword( $uId,$pswrd,password_hash($newPw, PASSWORD_DEFAULT));
echo "</br>RESULT:" . $pwChangeResult;
?>