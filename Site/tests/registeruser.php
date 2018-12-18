<?php

include("../../Data/logInManager.php");
// use ..\..\Data\logInManager;

// set message as success or fail on POST submit
$message = "";

// execute if POST, save results in message
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $message = print_r(registerUser($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["password"], $_POST["email"], null));
}

?>
<head>
    <title>user registration test</title>
</head>
<body>
    <?php
        // if message, output
        if ($message !== "") {
            echo "<div><h3>".$message."</h3></div>";
        }
    ?>
    <div>
        <form method="post">
            <label for="firstnametest">First Name:</label>
            <input
                id="firstnametest"
                name="firstname"
                type="text"
            />
            <br />
            <label for="lastnametest">Last Name:</label>
            <input
                id="lastnametest"
                name="lastname"
                type="text"
            />
            <br />
            <label for="usernametest">Username:</label>
            <input
                id="usernametest"
                name="username"
                type="text"
            />
            <br />
            <label for="passwordtest">Password:</label>
            <input
                id="passwordtest"
                name="password"
                type="password"
            />
            <br />
            <label for="emailtest">Email:</label>
            <input
                id="emailtest"
                name="email"
                type="email"
            />
            <br />
            <input
                id="submitbutton"
                type="submit"
                value="Submit"
            />
        </form>
    </div>
</body>