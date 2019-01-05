<?php
session_start();
session_regenerate_id(true);
include("../Data/dbConnector.php");
include("../Data/logInManager.php");
include("../Data/userManager.php");
$error = "";
$success = "";
//POST-MANAGER
if(isset($_POST['submit'])){
switch($_POST['submit']) {
  case 'Sign In': 
  // echo "<pre>";
  // print_r($_POST);
  // if(isset($_FILES)){
    
  //   $file = $_FILES['file'];
  //   if($file['name'] != ""){
  //     print_r($file);
  //   }
  // }
  // echo "</pre>";
  
  if(isset($_POST['firstname']) && !empty(trim($_POST['firstname'])) && strlen(trim($_POST['firstname'])) <= 30){
    $firstname = htmlspecialchars(trim($_POST['firstname']));
  } else {
    $error .= "vorname is missing</br>";
  }
  if(isset($_POST['lastname']) && !empty(trim($_POST['lastname'])) && strlen(trim($_POST['lastname'])) <= 50){
    $lastname = htmlspecialchars(trim($_POST['lastname']));
  } else {
    $error .= "nachname Feis missinghlt</br>";
  }
  if(isset($_POST['username']) && !empty(trim($_POST['username'])) && strlen(trim($_POST['username'])) <= 30){
    $res = checkUserOrEmailExists(htmlspecialchars(trim($_POST['username'])),"");
    if($res[0] != 1){
      $username = htmlspecialchars(trim($_POST['username']));
    }else{
      $error .= "username already exists, please use another one</br>";
    }
  } else {
    $error .= "username is missing</br>";
  }
  
  if(isset($_POST['email']) && !empty(trim($_POST['email'])) && strlen(trim($_POST['email'])) <= 100){
    $res = checkUserOrEmailExists("",htmlspecialchars(trim($_POST['email'])));
    if($res[1] != 1){
      $email = htmlspecialchars(trim($_POST['email']));
    }else{
      $error .= "email already exits, please use another one</br>";
    }
    
  } else {
    $error .= "email is missing</br>";
  }
  
  if(isset($_POST['password']) && !empty(trim($_POST['password'])) && strlen(trim($_POST['password'])) <= 100){
    $password = htmlspecialchars(trim($_POST['password']));
  } else {
    $error .= "password is missing</br>";
  }
  //check if picture is set
  $hasPic = false;
  if(isset($_FILES)){
    
    $file = $_FILES['file'];
    if($file['name'] != ""){
      $hasPic = true;
    }
  }

  if($hasPic == true){
    //check pic type
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];
    if($fileError == 1){
      $error .= "something went wrong with the picture </br>";
    }else{
     if($fileSize > 2048000){
      $error .= "filesize not supported</br>";
     }else{
      //TODO: check for type
      $fileExt = explode('.',$fileName);
      $fileAcExt = strtolower(end($fileExt));
      $allowed = array('jpg','jpeg','png');
      if(in_array($fileAcExt,$allowed)){
        if($error == ""){
          $res = registerUser($firstname,$lastname,$username,password_hash($password,PASSWORD_DEFAULT),$email,$file);
          if($res[1] == true){
            //success
            //TODO: Set session
            $_SESSION['IsLogIn'] = true;
            $_SESSION['userName'] = $username;
            $_SESSION['uId'] = $res[0];
  
          }else{
            $error .= "Something went wrong with the log in";
          }
        }
      }else{
        $error .= "image file type not supported</br>";
      }
      
     }
    }
  }else{
    if($error == ""){
    $res = registerUser($firstname,$lastname,$username,password_hash($password,PASSWORD_DEFAULT),$email,null);
        if($res[1] == true){
          //success
          //TODO: Set session
          $_SESSION['IsLogIn'] = true;
          $_SESSION['userName'] = $username;
          $_SESSION['uId'] = $res[0];
        }else{
          $error .= "Something went wong with the log in";
        
        }
      }
  }


  break;
  case 'Log In':
  $username = htmlspecialchars(trim($_POST['username']));
  $password = htmlspecialchars(trim($_POST['password']));
  $res = checkUserOrPasswordExists($username,$password);
  if($res[1] == 1){
          $_SESSION['IsLogIn'] = true;
          $_SESSION['userName'] = $username;
          $_SESSION['uId'] = $res[0];
  }else{
    $error .= "username or password worng. Please try again</br>";
  }
  break;
  case 'Change Password':
  $oldPassword = "";
  $newPasswordHashed = "";
  if((isset($_POST['OldPassword']) && !empty(trim($_POST['OldPassword'])) && strlen(trim($_POST['OldPassword'])) <= 100) && (isset($_POST['NewPassword']) && !empty(trim($_POST['NewPassword'])) && strlen(trim($_POST['NewPassword'])) <= 100)){
    $oldPassword = htmlspecialchars(trim($_POST['OldPassword']));
    $newPasswordHashed = password_hash( htmlspecialchars(trim($_POST['NewPassword'])),PASSWORD_DEFAULT);
    $res = changePassword($_SESSION['uId'],$oldPassword,$newPasswordHashed);
    if($res){
      $success .= "The password was succesfully changed! </br>";
    }else{
      $error .= "something went wrong or your old password is wrong, please try again </br>";
    }
  } else {
    $error .= "old or new password is missing</br>";
  }
  break;
  case 'Change Username':
  if(isset($_POST['username']) && !empty(trim($_POST['username'])) && strlen(trim($_POST['username'])) <= 30){
    $res = checkUserOrEmailExists(htmlspecialchars(trim($_POST['username'])),"");
    if($res[0] != 1){
      $username = htmlspecialchars(trim($_POST['username']));
      $res = changeUserName($_SESSION['uId'],$username);
  if($res){
    $success .= "your username was changed successfuly. You're now called " . $username . "</br>";
  }else{
    $error .= "something went wrong while changing your username";
  }
  //update session
  $_SESSION['userName'] = $username;

    }else{
      $error .= "username already exists, please use another one</br>";
    }
  } else {
    $error .= "username format not supported, please try another one</br>";
  }
  break;
  case 'Log Out':
  session_destroy();
  header("Location: index.php");
  break;
}

}

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="styles/index.css"/>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<title>Let's Chat! Homepage</title>
</head>
<body>
<div>
<!--Navigation Bar with User Icon and Chat Link-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
     <!-- Index Page, Where the LogIn and Register Forms are -->
        <a class="navbar-brand" href="index.php">Let's Chat!</a>
        <!-- Toggler for responsive solutions -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#CollapsableNavbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <!-- Navigation selections -->
              <div class="collapse navbar-collapse" id="CollapsableNavbarNav">
                    <ul class="navbar-nav  mr-auto">
                        
                        <li class="nav-item">
                           <!-- Main Chat Page, only accessable when logged in -->
                           <?php 
                           if(isset($_SESSION['IsLogIn'])){
                             if($_SESSION['IsLogIn'] == true){
                               ?> 
                               <a class="nav-link" href="chat.php">Chat!</a>
                               <?php
                             }
                           }
                           ?>
                          
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                    <!-- User Dropdown with change Password and Log out -->
                    <?php 
                           if(isset($_SESSION['IsLogIn'])){
                             if($_SESSION['IsLogIn'] == true){
                               ?> 
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="UserDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="../Image/Profile_Pictures/<?php echo getImageNameFromUid($_SESSION['uId']) ?>" width="30" height="30" class="d-inline-block align-top rounded-circle border border-dark" alt="">
                                    <?php echo $_SESSION['userName'] ?>
                                </a>
                                <div class="shadow dropdown-menu" aria-labelledby="UserDropdownMenuLink">
                                    <a class="dropdown-item" href="#" data-target="#pswdChangeMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Change Password</a>
                                    <a class="dropdown-item" href="#" data-target="#changeusrnameMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Change Username</a>
                                    <form atrcion="" Method="POST">
                                    <input type="submit" value="Log Out" name="submit" class="dropdown-item">
                                    </form>
                                    
                                </div>
                            </li>
                            <?php
                             }
                           }
                           ?>
                           
                    </ul>
                </div>
      </nav>
</div>
<?php
if($error != ""){
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
<?php echo $error ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}
?>
<?php
if($success != ""){
?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
<?php echo $success ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}
?>
<div id="content">
    <div class="jumbotron">
<h1 class="text-center">Let's Chat!</h1>
<p class="lead text-center">This is our fist Website with complete functional user system! Sign In and choose your own name and profile picture! The best part is, you can also chat with other users!</p>
<?php 
if(! isset($_SESSION['IsLogIn'])){
                               ?> 
        <p class="text-center"><a class="btn btn-lg btn-success btn " role="button" data-target="#SignInMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Sign up</a></p>
        <p class="text-center"><a class="btn btn-lg btn-success btn " role="button"  data-target="#LogInMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Log In</a></p>
        <?php
                             }elseif($_SESSION['IsLogIn'] == false){
                               ?>
                                       <p class="text-center"><a class="btn btn-lg btn-success btn " role="button" data-target="#SignInMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Sign up</a></p>
                                        <p class="text-center"><a class="btn btn-lg btn-success btn " role="button"  data-target="#LogInMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Log In</a></p>

                               <?php
                             }
                           ?>
    </div>
    
          <h2 class="text-center">Heading</h2> 
          <p class="text-center">This Website was created for a school project. Our chatservice is saver than Whatsapp (please trust us). Visit our github repository and leave a star!</p>
          <p class="text-center"><a class="btn btn-primary" href="https://github.com/P30dSW/EncryptedChat" role="button">Github Rep &raquo;</a></p>
    
                            
<!-- Login in Sign In Modals -->
 <div class="modal fade" id="SignInMdl" tabindex="-1" role="dialog" aria-labelledby="singInLbl" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="singInLbl">Sign In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- TODO: Action and Method -->
        <form action="" method="POST" enctype="multipart/form-data">
        <!-- TODO: add verification patters -->
        <div class="form-group">
        <label for="fstNameInputSignIn">First Name</label>
        <input id="fstNameInputSignIn"class="form-control" type="text" placeholder="First Name" required="true" name="firstname" maxlength="30">
        </div>
        <div class="form-group">
        <label for="lstnmInputSignIn">Last Name</label>
        <input id="lstnmInputSignIn"class="form-control" type="text" placeholder="Last Name" required="true" maxlength="50" name="lastname">
        </div>
        <div class="form-group">
        <label for="usrnmInputSignIn">Username</label>
        <input id="usrnmInputSignIn"class="form-control" type="text" placeholder="Username" maxlength="30" required="true" name="username" pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{6,}">
        <small class="form-text text-muted">longer than 6 characters,must contain a capital letter</small>
      </div>
        <div class="form-group">

        <label for="emailInputSignIn">Email address</label>
        <input type="email" class="form-control" id="emailInputSignIn" placeholder="name@example.com" required="true" maxlength="100" name="email">
        </div>
        <div class="form-group">
        <label for="passwordInputSignIn">Password</label>
        <input type="password" class="form-control" id="passwordInputSignIn" placeholder="Password" required="true" name="password" pattern="(?=^.{8,}$)(?=.*\d+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="100">
        <small class="form-text text-muted">longer than 8 characters, needs to contain a capital letter and a number</small>
        </div>
        <div class="form-group">
          <label for="userProfileInputSignIn">User Profile</label>
          <input type="file" name="file" class="form-control-file" id="userProfileInputSignIn">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Sign In" name="submit">
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="LogInMdl" tabindex="-1" role="dialog" aria-labelledby="logInLbl" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logInLbl">Log In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- TODO: Action and Method -->
        <form action="" method="POST">
        <!-- TODO: add verification patters -->
        <div class="form-group">
        <label for="usrnmInputLogIn">Username</label>
        <input id="usrnmInputLogIn"class="form-control" type="text" required="true" placeholder="Username" name="username">
        <small class="form-text text-muted">longer than 6 characters,must contain a capital letter</small>
      </div>
        <div class="form-group">
        <label for="passwordInputLogIn">Password</label>
        <input type="password" class="form-control" id="passwordInputLogIn" placeholder="Password" name="password" required="true" pattern="(?=^.{8,}$)(?=.*\d+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="100">
        <small class="form-text text-muted">longer than 8 characters, needs to contain a capital letter and a number</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Log In" name="submit">
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="pswdChangeMdl" tabindex="-1" role="dialog" aria-labelledby="changepswdLbl" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changepswdLbl">Change Pasword</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
        <div class="form-group">
        <label for=newPswdChangeInput">Old Password</label>
        <input type="password" name="OldPassword" class="form-control" id="newPswdChangeInput" placeholder="New Password" required="true" pattern="(?=^.{8,}$)(?=.*\d+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="100">
        <small class="form-text text-muted">longer than 8 characters, needs to contain a capital letter and a number</small>
        </div>
        <div class="form-group">
        <label for=newPswdChangeInput">New Password</label>
        <input type="password" name="NewPassword" class="form-control" id="newPswdChangeInput" placeholder="New Password" required="true" pattern="(?=^.{8,}$)(?=.*\d+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="100">
        <small class="form-text text-muted">longer than 8 characters, needs to contain a capital letter and a number</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Change Password" name="submit">
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="changeusrnameMdl" tabindex="-1" role="dialog" aria-labelledby="changeusrnameLbl" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeusrnameLbl">Change Username</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
        <div class="form-group">
        <label for=newUseranmeInput">New Username</label>
        <input name="username" type="text" class="form-control" id="newUseranmeInput" placeholder="New Username" maxlength="30" required="true" name="username" pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{6,}">
        <small class="form-text text-muted">longer than 6 characters,must contain a capital letter</small>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <input type="submit" class="btn btn-primary" value="Change Username" name="submit">
      </div>
      </form>
    </div>
  </div>
</div>
<footer class="footer">
        <p calss="text-center" >&copy; GIBM 2018</p>
</footer>
</div>
</body>
</html>