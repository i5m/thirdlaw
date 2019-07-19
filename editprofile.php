<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$u = $_SESSION["username"];
?>

<?php
require_once('header.php');
$sql = "SELECT * FROM users WHERE username='$u'";
$result = $link->query($sql);
$row = mysqli_fetch_array($result);
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $a = $b = 1;
    
    if (file_exists($_FILES['profilepic']['tmp_name']) || is_uploaded_file($_FILES['profilepic']['tmp_name'])) {

        $target_dir = "img/profilepic/";
        $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profilepic"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["profilepic"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            $newfilename = $target_dir . $u . "_" . md5($target_file) . '.' . $imageFileType;
            if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $newfilename)) {
                $sqlpic = "UPDATE users SET ploc='$newfilename' WHERE username='" . $u . "'";
                if ($link->query($sqlpic) === TRUE) {
                    $a = 0;
                } else {
                    echo "Error: " . $sqlpic . "<br>" . $link->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file." . "<br>";
            }
        }
    } else { $a = 0; }

    // Prepare an insert statement
    $sql = "UPDATE users SET bio=?, fullname=?, phone=?, bday=?, city=?, college=?, instaprof=? WHERE username='" . $u . "'";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssssss", $param_bio, $param_fullname, $param_phone, $param_bday, $param_city, $param_college, $param_instaprof);

        // Set parameters
        $param_bio = $_POST["bio"];
        $param_bday = $_POST["bday"];
        $param_fullname = $_POST["fullname"];
        $param_phone = $_POST["phone"];
        $param_city = $_POST["city"];
        $param_college = $_POST["college"];
        if($_POST["instaprof"] !== "") { $param_instaprof = "https://instagram.com/".$_POST["instaprof"]; }
        else { $param_instaprof = ""; }

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) { $b = 0; }
        else { echo "Error: " . $sql . "<br>" . $link->error; }
    }

    if ($a == 0 && $b == 0) {
        header("location: my.php");
    }

    $link->close();
}
?>

<style>
    @media only screen and (min-width: 650px) { #editprofile { margin-top: 30px; } }
    #output {
        border-radius: 20px;
        max-width: 150px;
        width: auto;
        max-height: 150px;
        height: auto;
        border: 1px solid gray;
        padding: 5px; 
    }
    #profilepiclabel {
        cursor: pointer;
        border: 2px solid gray;
        padding: 5px;
        border-radius: 5px;
    }
    #profilepic { display: none; }
</style>
</head>

<body>

    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navProfile").addClass("activehai");
            $("#navProfile i").removeClass("material-icons-outlined");
            $("#navProfile i").addClass("material-icons");
        });
    </script>

    <div class="container" id="editprofile">
        <br>
        <h3><i class="material-icons-outlined">settings</i> <b>Edit Profile</b></h3>
        <a style="color: red;" href="my.php"><i class="material-icons-outlined">keyboard_arrow_left</i> Cancel</a>
        <div class="dropdown-divider"></div><br>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col" style="min-width: 220px;">
                    <img id="output" src="<?php echo $row["ploc"]; ?>"><br><br>
                    <label for="profilepic" id="profilepiclabel">Update Picture</label>
                    <input type="file" onchange="loadFile(event)" name="profilepic" id="profilepic" accept="image/png, image/jpeg, image/gif">
                    <br><br>
                    <script>
                        var loadFile = function(event) {
                            var output = document.getElementById('output');
                            output.src = URL.createObjectURL(event.target.files[0]);
                        };
                    </script>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="material-icons-outlined">sentiment_satisfied</i> <b>Bio</b></span>
                        </div>
                        <textarea name="bio" rows="5" maxlength="123" class="form-control" aria-label="With textarea"><?php echo $row["bio"]; ?></textarea>
                    </div><br><br>
                </div>
                <div class="col" style="min-width: 220px;">
                    <b>Name:</b>    
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">person</i></span>
                        </div>
                        <input required type="text" name="fullname" class="form-control" value="<?php echo $row["fullname"]; ?>" placeholder="Full Name" aria-label="Full Name" aria-describedby="basic-addon1">
                        <span id="fullname_err"></span>
                    </div><br>
                    <b>Birthday:</b>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">cake</i></span>
                        </div>
                        <input type="date" name="bday" class="form-control" value="<?php echo $row["bday"]; ?>" type="date" min="1900-01-01" max="2025-12-31" value="<?php echo $row["bday"]; ?>">
                    </div><br>
                    <b>Phone no.</b>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">phone</i></span>
                        </div>
                        <input type="text" name="phone" pattern="[0-9]{10}" class="form-control" value="<?php echo $row["phone"]; ?>" placeholder="Phone Number (optional)" aria-label="Phone Number (optional)" aria-describedby="basic-addon1">
                    </div><br>
                    <b>College/ School:</b>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">account_balance</i></span>
                        </div>
                        <input type="text" name="college" class="form-control" value="<?php echo $row["college"]; ?>" placeholder="Education" aria-label="Eucation" aria-describedby="basic-addon1">
                    </div><br>
                    <b>City:</b>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">location_city</i></span>
                        </div>
                        <input required type="text" name="city" class="form-control" value="<?php echo $row["city"]; ?>" placeholder="City" aria-label="City" aria-describedby="basic-addon1">
                        <span id="city_err"></span>
                    </div><br>
                    <b>Instagram username:</b>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons">alternate_email</i></span>
                        </div>
                        <input required type="text" name="instaprof" class="form-control" value="<?php echo $row["instaprof"]; ?>" placeholder="Instagram Username" aria-label="Instagram Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div><br>
            <div align="center"><button id="updateBtn" type="submit" class="btn btn-primary someSpecific"><i class="material-icons-outlined">done_all</i> <b>Update</b></button></div>
        </form>
    </div><br><br><br><br>
    <?php require_once('footer.php'); ?>