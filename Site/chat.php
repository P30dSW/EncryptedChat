<?php
session_start();
session_regenerate_id(true);
include("../Data/dbConnector.php");
include("../Data/logInManager.php");
include("../Data/userManager.php");

$error = "";
$success ="";
//POST-MANAGER
if(isset($_POST['submit'])){
  
  switch($_POST['submit']) {
    case 'Log Out':
    session_destroy();
    header("Location: index.php");
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
  }
}



//checks if there valid is a session active

                           if(isset($_SESSION['IsLogIn'])){
                             if($_SESSION['IsLogIn'] == true){
                               
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="styles/chat.css"/>
<link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
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
                    <ul class="navbar-nav" >
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
 <!-- chat layout reference: https://bootsnipp.com/snippets/featured/message-chat-box -->
<div class="row">
<div data-simplebar class="userList container col-md-4 border border-secondary rounded bg-light">
  
<?php
//Set Userlist here
$userListJSON = "[{\"uId\":1,\"userName\":\"testUser01\",\"profileSrc\":\"img/dummy_2.jpeg\"},{\"uId\":2,\"userName\":\"testUser02\",\"profileSrc\":\"img/dummy_profile.png\"},{\"uId\":3,\"userName\":\"testUser03\",\"profileSrc\":\"img/dummy_profile.png\"},{\"uId\":4,\"userName\":\"testUser04\",\"profileSrc\":\"img/dummy_profile.png\"},{\"uId\":5,\"userName\":\"testUser05\",\"profileSrc\":\"img/dummy_profile.png\"}]";
$userList = getListOfAllUsers();
//removes current user

foreach ($userList as $user) {
if($user['uId'] != $_SESSION['uId'] && $user['uId'] != null){
    ?>
    <div data-tilt data-tilt-axis="y" class="shadow users card border border-grey rounded mt-1 md-1 m-1 " uId="<?php echo $user['uId']?>" userName="<?php echo $user['userName']?>">
   
        <div class="d-flex text-dark">
    
        <img class="rounded-circle border border-dark mt-1 md-1 m-1" src="../Image/Profile_Pictures/<?php echo $user['profilePicName'] ?>" height="50" width="50" />
        <p class="userNameOnCard"><?php echo $user['userName']; ?></p>
</div>
        
</div>
    <?php
}
}
?>

</div>
<div class="container col-md-8 border border-secondary rounded bg-light">
<div class="mesgs">
          <div class="msg_history ">
          <div data-simplebar class="msg_scroll_content">
          <div class="sent_msg">
                <p>BOI
                </br>
                <small><i>18.12.18 08:00</i></small>
                </br>
                <button id="changeMessageBtn" type="button" class="changeMessageBtn btn btn-secondary btn-sm rounded-circle" href="#" data-target="#editMessageMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">✏</button>
                <!-- TODO: calls a ajay js function -->
                <button id="deleteMessageBtn" type="button" class="btn btn-secondary btn-sm rounded-circle">🗑</button></p>
            </div>
            
            
            
              <div class="received_msg">
                
                  <p>Test which is a new approach to have all
                    solutions</br> idjsidjvisjvsid</br>dcjisdcisjcisjdc</p>
              
            </div>
        
       
              <div class="received_msg">
                
                  <p>Test which is a new approach to have all
                    solutions</br> idjsidjvisjvsid</br>dcjisdcisjcisjdc</p>
              
            </div>
            
        
        
              <div class="received_msg">
                
                  <p>Test which is a new approach to have all
                    solutions</br> idjsidjvisjvsid</br>dcjisdcisjcisjdc</p>
              
            </div>
            
        
        
              <div class="received_msg">
                
                  <p>Test which is a new approach to have all
                    solutions</br> idjsidjvisjvsid</br>dcjisdcisjcisjdc</p>
              
            </div>
            
        
        
              <div class="received_msg">
                
                  <p>Test which is a new approach to have all
                    solutions</br> idjsidjvisjvsid</br>dcjisdcisjcisjdc</p>
              
            </div>
            
        
        
              <div class="received_msg">
                
                  <p>Test which is a new approach to have all
                    solutions</br> idjsidjvisjvsid</br>dcjisdcisjcisjdc</p>
              
            
            
        </div>
        <div class="sent_msg">
                <p>Wut?</p>
        
        </div>
</div>
        </div>
        <div class="typeMsg">
            <div class="inputMsg">
              <input type="text" placeholder="Type a message" />
              <button class="sendMsgBtn btn align-middle" type="button">Send!</button>
            </div>
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
<!-- change unsername modal  -->
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
        <form action="" method="POST">
        <!-- TODO: add verification patterns -->
        <div class="form-group">
        <label for=newUseranmeInput">New Username</label>
        <input name="username" type="text" class="form-control" id="newUseranmeInput" placeholder="New Username" maxlength="30" required="true" name="username" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,}">
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
<!-- edit message Modal
TODO: goes through js. adds the mId in the modal attributes -->
<div class="modal fade" id="editMessageMdl" tabindex="-1" role="dialog" aria-labelledby="editMsgLbl" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMsgLbl">Edit Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- TODO: goes through ajax -->
        <form>
        <div class="form-group">
        <label for="editMessageInput">New Message</label>
        <textarea class="form-control" id="editMessageInput" rows="3"></textarea>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  type="submit" class="btn btn-primary">Edit Message</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<footer class="footer">
        <p calss="text-center" >&copy; GIBM 2018</p>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://unpkg.com/simplebar@latest/dist/simplebar.js"></script>
<script src="scripts/chat.js"></script>
</body>
</html>
<?php
                             }else{
                              header("Location: index.php");
                             }

                            }else{
                              header("Location: index.php");
                            }?>