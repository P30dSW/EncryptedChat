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
        <form>
        <!-- TODO: add verification patters -->
        <div class="form-group">
        <label for="fstNameInputSignIn">First Name</label>
        <input id="fstNameInputSignIn"class="form-control" type="text" placeholder="First Name">
        </div>
        <div class="form-group">
        <label for="lstnmInputSignIn">Last Name</label>
        <input id="lstnmInputSignIn"class="form-control" type="text" placeholder="Last Name">
        </div>
        <div class="form-group">
        <label for="usrnmInputSignIn">Username</label>
        <input id="usrnmInputSignIn"class="form-control" type="text" placeholder="Username">
        </div>
        <div class="form-group">

        <label for="emailInputSignIn">Email address</label>
        <input type="email" class="form-control" id="emailInputSignIn" placeholder="name@example.com">
        </div>
        <div class="form-group">
        <label for="passwordInputSignIn">Password</label>
        <input type="password" class="form-control" id="passwordInputSignIn" placeholder="Password">
        </div>
        <div class="form-group">
    <label for="userProfileInputSignIn">User Profile</label>
    <input type="file" class="form-control-file" id="userProfileInputSignIn">
  </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  type="submit" class="btn btn-primary">Sign In</button>
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