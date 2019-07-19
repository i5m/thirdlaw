<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$u = $_SESSION["username"];

// Include config file
require_once "header.php";

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
    } else {
        $sqlpic = "UPDATE users SET ploc='img/profilepic/default.png' WHERE username='" . $u . "'";
        if ($link->query($sqlpic) === TRUE) {
            $a = 0;
        } else {
            echo "Error: " . $sqlpic . "<br>" . $link->error;
        }
    }
    
    // Prepare an insert statement
    $sql = "UPDATE users SET fullname=?, phone=?, city=? WHERE username='" . $u . "'";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_fullname, $param_phone, $param_city);

        // Set parameters
        $param_fullname = $_POST["fullname"];
        $param_phone = $_POST["phone"];
        $param_city = $_POST["city"];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) { $b = 0; }
        else { echo "Error: " . $sql . "<br>" . $link->error; }
    }

    if ($a == 0 && $b == 0) {
        header("location: /");
    }

    $link->close();
}

?>

<style>
    .container {
        background-color: #ffffff;
        max-width: 800px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
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
    <div class="container" align="center">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <h3><b>The Last Step</b></h3>
            <p style="color: gray;">for better experience</p><br>
            <div class="row">
                <div class="col" style="min-width: 220px;">
                    <img id="output" src="img/profilepic/default.png"><br><br>
                    <label for="profilepic" id="profilepiclabel">Profile Picture</label>
                    <input type="file" onchange="loadFile(event)" name="profilepic" id="profilepic" accept="image/png, image/jpeg, image/gif">
                    <br><br>
                    <script>
                        var loadFile = function(event) {
                            var output = document.getElementById('output');
                            output.src = URL.createObjectURL(event.target.files[0]);
                        };
                    </script>
                </div>
                <div class="col" style="min-width: 220px;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">person</i></span>
                        </div>
                        <input required type="text" name="fullname" class="form-control" placeholder="Full Name" aria-label="Full Name" aria-describedby="basic-addon1">
                        <span id="fullname_err"></span>
                    </div><br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">phone</i></span>
                        </div>
                        <input type="text" name="phone" pattern="[1-9]{10}" class="form-control" placeholder="Phone Number (optional)" aria-label="Phone Number (optional)" aria-describedby="basic-addon1">
                    </div><br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">location_city</i></span>
                        </div>
                        <input required type="text" name="city" class="form-control" placeholder="City" aria-label="City" aria-describedby="basic-addon1">
                        <span id="city_err"></span>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-outline-primary someSpecific"><b>Let's Start</b></button>
        </form>
        <!--<br><br><br>
        <div id="progressbar">
            <div class="progress" id="firststep">
                <div class="progress-bar bg-success" role="progressbar" style="width: 33%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Profile Created</div>
                <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Full Name</div>
                <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Phone & City</div>
            </div>
        </div>-->
    </div>

    <?php require_once('footer.php'); ?>