<?php
session_start();
session_regenerate_id(true);
include("../Data/dbConnector.php");
include("../Data/logInManager.php");
include("../Data/userManager.php");
//TODO: Ausgabe der fehlermeldung im html file
$error = "";


//POST-MANAGER
if(isset($_POST['submit'])){
switch($_POST['submit']) {
  case 'Sign In': 
  echo "<pre>";
  print_r($_POST);
  if(isset($_FILES)){
    
    $file = $_FILES['file'];
    if($file['name'] != ""){
      print_r($file);
    }
  }
  echo "</pre>";
  
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
  //TODO:CHECK if username already exists
  if(isset($_POST['username']) && !empty(trim($_POST['username'])) && strlen(trim($_POST['username'])) <= 30){
    $username = htmlspecialchars(trim($_POST['username']));
  } else {
    $error .= "username is missing</br>";
  }
  if(isset($_POST['email']) && !empty(trim($_POST['email'])) && strlen(trim($_POST['email'])) <= 100){
    $email = htmlspecialchars(trim($_POST['email']));
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
      $error .= "something wrong with the picture </br>";
    }else{
     if($fileSize > 1000000){
      $error .= "filesize not supported</br>";
     }else{
      //TODO: check for type
      if($error == ""){
        $res = registerUser($firstname,$lastname,$username,password_hash($password,PASSWORD_DEFAULT),$email,$file);
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
    }
  }else{
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


  break;
  case 'Log In':
  //...
  break;
  case 'Change Password':
  //...
  break;
  case 'Change Username':
  //...
  break;
}

if($error != ""){
  echo "<pre>";
  echo $error;
  echo "</pre>";
}
}

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
                                    <img src="../src/Profile_Pictures/<?php echo getImageNameFromUid($_SESSION['uId']) ?>" width="30" height="30" class="d-inline-block align-top rounded-circle border border-dark" alt="">
                                    <?php echo $_SESSION['userName'] ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="UserDropdownMenuLink">
                                    <a class="dropdown-item" href="#" data-target="#pswdChangeMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Change Password</a>
                                    <a class="dropdown-item" href="#" data-target="#changeusrnameMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Change Username</a>
                                    <a class="dropdown-item" href="#">Log Out</a>
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
    <div class="jumbotron">
<h1 class="text-center">Let's Chat!</h1>
<p class="lead text-center">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p class="text-center"><a class="btn btn-lg btn-success btn " role="button" data-target="#SignInMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Sign up</a></p>
        <p class="text-center"><a class="btn btn-lg btn-success btn " role="button"  data-target="#LogInMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Log In</a></p>
    </div>
    
          <h2 class="text-center">Heading</h2> 
          <p class="text-center">Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p class="text-center"><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
    

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
        <input id="usrnmInputSignIn"class="form-control" type="text" placeholder="Username" maxlength="30" required="true" name="username" pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}">
        </div>
        <div class="form-group">

        <label for="emailInputSignIn">Email address</label>
        <input type="email" class="form-control" id="emailInputSignIn" placeholder="name@example.com" required="true" maxlength="100" name="email">
        </div>
        <div class="form-group">
        <label for="passwordInputSignIn">Password</label>
        <input type="password" class="form-control" id="passwordInputSignIn" placeholder="Password" required="true" name="password" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="100">
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
        <form>
        <!-- TODO: add verification patters -->
        <div class="form-group">
        <label for="usrnmInputLogIn">Username</label>
        <input id="usrnmInputLogIn"class="form-control" type="text" placeholder="Username">
        </div>
        <div class="form-group">
        <label for="passwordInputLogIn">Password</label>
        <input type="password" class="form-control" id="passwordInputLogIn" placeholder="Password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  type="submit" class="btn btn-primary">Log In</button>
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
        <!-- TODO: Action and Method -->
        <form>
        <!-- TODO: add verification patters -->
        <div class="form-group">
        <label for="currentPswdChangeInput">Current Password</label>
        <input type="password" class="form-control" id="currentpswdChangeInput" placeholder="Current Password">
        </div>
        <div class="form-group">
        <label for=newPswdChangeInput">New Password</label>
        <input type="password" class="form-control" id="newPswdChangeInput" placeholder="New Password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" type="submit" class="btn btn-primary">Change Password</button>
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
        <!-- TODO: Action and Method -->
        <form>
        <!-- TODO: add verification patterns -->
        <div class="form-group">
        <label for=newUseranmeInput">New Username</label>
        <input type="text" class="form-control" id="newUseranmeInput" placeholder="New Username">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  type="submit" class="btn btn-primary">Change Username</button>
      </div>
      </form>
    </div>
  </div>
</div>
<footer class="footer">
        <p calss="text-center" >&copy; GIBM 2018</p>
</footer>

</body>
</html>