<?php
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
$resultExists = checkUserOrEmailExists($usrname,$eMail);
if($resultExists[0] == true && $resultExists[1] == true){
  $resultExistsBool = true;
}
//------check if user exists Tests returns Boolean
// $result = checkUserOrPasswordExists($usrname ,$pswrd );
//  foreach ($result as $key => $val) {
//      echo $val;
//   }

  //------change password of existing user
  echo "Test Case:changing Password";
$pwChangeResult =  changePassword( $uId,$pswrd,password_hash($newPw, PASSWORD_DEFAULT));
echo "</br>RESULT:" . $pwChangeResult;

//------change username
$res = changeUserName(6,"DamnLongNeck");
echo $res;
?>
