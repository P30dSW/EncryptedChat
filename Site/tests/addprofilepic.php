<?php

include("../../Data/logInManager.php");
// use ..\..\Data\logInManager;

// set message as success or fail on POST submit
$message = "";

// execute if POST, save results in message
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // $message = print_r($_POST["userfile"]);
    $sent_image = $_FILES['userfile'];
    $message = print_r(addProfilePicture($sent_image));
}

?>
<head>
    <title>profile picture change test</title>
</head>
<body>
    <?php
        // if message, output
        if ($message !== "") {
            echo "<div><h3>".$message."</h3></div>";
        }
    ?>
    <div>
        <form enctype="multipart/form-data" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <label for="imageupload">Image Upload:</label>
            <input
                id="imageupload"
                name="userfile"
                type="file"
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