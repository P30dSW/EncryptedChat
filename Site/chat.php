<?php

//check for POST data
//case 1: Login
//case 2: Registration

//if no POST data, it's just the main login page
//include("login.html");

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="styles/chat.css"/>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="scripts/chat.js"></script>
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
                          <a class="nav-link" href="chat.php">Chat!</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                    <!-- User Dropdown with change Password and Log out -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="UserDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="src/dummy_profile.png" width="30" height="30" class="d-inline-block align-top rounded-circle border border-dark" alt="">
                                    [UserNameHERE]
                                </a>
                                <div class="dropdown-menu" aria-labelledby="UserDropdownMenuLink">
                                    <a class="dropdown-item" href="#" data-target="#pswdChangeMdl" data-toggle="modal" data-backdrop="static" data-keyboard="false">Change Password</a>
                                    <a class="dropdown-item" href="#">Log Out</a>
                                </div>
                            </li>
                           
                    </ul>
                </div>
      </nav>
</div>
 <!-- chat layout reference: https://bootsnipp.com/snippets/featured/message-chat-box -->
<div class="row">
<div class=" userList container col-md-4 border border-dark rounded">
<?php
//Set Userlist here
$userListJSON = "[{\"uId\":1,\"userName\":\"testUser01\",\"profileSrc\":\"src/dummy_2.jpeg\"},{\"uId\":2,\"userName\":\"testUser02\",\"profileSrc\":\"src/dummy_profile.png\"},{\"uId\":3,\"userName\":\"testUser03\",\"profileSrc\":\"src/dummy_profile.png\"},{\"uId\":4,\"userName\":\"testUser04\",\"profileSrc\":\"src/dummy_profile.png\"},{\"uId\":5,\"userName\":\"testUser05\",\"profileSrc\":\"src/dummy_profile.png\"}]";

foreach (json_decode($userListJSON) as $list) {

    ?>
    
    <div class="users card border border-grey rounded mt-1 md-1 m-1" uId="<?php echo $list->{'uId'}?>" userName="<?php echo $list->{'userName'}?>">
   
        <div class="d-flex text-dark">
    
        <img class="rounded-circle border border-dark mt-1 md-1 m-1" src="<?php echo $list->{'profileSrc'} ?>" height="50" width="50" />
        <p><?php echo $list->{'userName'}; ?></p>

</div>
        
</div>
    <?php
}
?>

</div>
<div class="container col-md-8 border border-dark rounded">
<div class="mesgs">
          <div class="msg_history ">
          
          <div class="sent_msg">
                <p>BOI</p>
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
        <form>
        <!-- TODO: add verification patterns -->
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
        <button type="button"  type="submit" class="btn btn-primary">Change Password</button>
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