<?php
include("../logInManager.php");
$usrname = 'testUser02';
$frstname = 'pedro';
$lastname = 'winkler';
$eMail = 'go@fuckyourself.com';
$pswrd = 'pussy';
//------creates User
$resultUser = registerUser($frstname,$lastname,$usrname,password_hash($pswrd, PASSWORD_DEFAULT) , $eMail );

//------check ob den username oder password schon existiert
$resultExists = checkUserOrEmailExists($usrname,$eMail);
if($resultExists[0] == true && $resultExists[1] == true){
  $resultExistsBool = true;
}
//------check if user exists Tests returns Boolean
$result = checkUserOrPasswordExists($usrname ,$pswrd );
 foreach ($result as $key => $val) {
     echo $val;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
  <?php
  if($resultUser){
    echo "<div class=\"alert alert-success\" role=\"alert\">Test Case User erstellen:</br> Erfolgreich</div>";

  }else{
    echo "<div class=\"alert alert-danger\" role=\"alert\">Test Case User erstellen:</br> Nicht Erfolgreich</div>";
  }

  if($resultExistsBool){
    echo "<div class=\"alert alert-success\" role=\"alert\">Test Case Email und User nachsuchen:</br> Erfolgreich</div>";

  }else{
    echo "<div class=\"alert alert-danger\" role=\"alert\">Test Case Email und User nachsuchen:</br> Nicht Erfolgreich</div>";

  }
  ?>
</body>
</html>