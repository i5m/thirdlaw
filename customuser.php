<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { header("location: /"); exit; }
else { $u = $_SESSION["username"]; }
require_once('header.php');
$navLeft = '<button class="btn" onclick="history.go(-1)"><i class="material-icons-outlined" style="font-weight: bold; vertical-align: top; color: #007bff;">arrow_back</i></button> <b style="font-size: 24px; vertical-align: middle;">Custom</b>';
?>
<?php
$sqlWhom = "SELECT id, username FROM users WHERE username='$u'";
$resultWhom = $link->query($sqlWhom);
$rowWhom = mysqli_fetch_array($resultWhom);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $a = 0;
    
    if (file_exists($_FILES['custompic']['tmp_name']) || is_uploaded_file($_FILES['custompic']['tmp_name'])) {

        $target_dir = "img/custompic/";
        $target_file = $target_dir . basename($_FILES["custompic"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["custompic"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        if ($_FILES["custompic"]["size"] > 700000) {
            echo "Sorry, the picture is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }
        if($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $src = imagecreatefromjpeg($_FILES["custompic"]["tmp_name"]);
        }
        else if($imageFileType == "png" || $imageFileType == "PNG") {
            $src = imagecreatefrompng($_FILES["custompic"]["tmp_name"]);
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            $newfilename = $target_dir . $u . "_" . md5($target_file) . '.' . $imageFileType;

            list($width_org, $height_org) = getimagesize($_FILES["custompic"]["tmp_name"]);
    
            $new_width = 200;
            $new_height = ($height_org / $width_org) * $new_width;

            $tmp_img_min = imagecreatetruecolor($new_width, $new_height);

            imagecopyresampled($tmp_img_min, $src, 0, 0, 0, 0, $new_width, $new_height, $width_org, $height_org);

            if($imageFileType == "jpg" || $imageFileType == "jpeg") {
                if(imagejpeg($tmp_img_min, $newfilename, 80)) { $a = 1; }
                else { echo "Sorry, there was an error uploading your file." . "<br>"; }
            }
            else if($imageFileType == "png" || $imageFileType == "PNG") {
                if(imagepng($tmp_img_min, $newfilename, 8)){ $a = 1; }
                else { echo "Sorry, there was an error uploading your file." . "<br>"; }
            }
        }
    } else { $a = 1; $newfilename = 'nocustompic'; }

    if($a == 1) {
        $sql = "INSERT INTO customuser (customname, crushername, customploc, customcity, customcollege, customphone, custombday, custominsta)
            VALUES (?, ?, '$newfilename', ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssss", $param_customname, $param_crushername, $param_customcity, $param_customcollege, $param_customphone, $param_custombday, $param_custominsta);

            $param_customname = $_POST["customName"];
            $param_crushername = $u;
            $param_customcity = $_POST["customCity"];
            $param_customcollege = $_POST["customCollege"];
            $param_customphone = $_POST["customPhone"];
            $param_custombday = $_POST["customBday"];
            if($_POST["customInsta"] !== "") { $param_custominsta = "https://instagram.com/".$_POST["customInsta"]; }
            else { $param_custominsta = ""; }

            if (mysqli_stmt_execute($stmt)) {
                echo '<div class="alert alert-success"><br/><h5>'.$param_customname.' succesfully added!!!<br/></h5></div>';
            }
            else { echo "Error: " . $sql . "<br>" . $link->error; }
        }
    }

}

?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</head>

<body>

    <?php require_once('nav.php'); ?>

    <div class="container"><br/>
        <div align="center">
            <img src="img/searchTools/custom.png"><br/>
            <h5><b>Custom Add</b></h5><br/>
            <h6>If you can't find any person here add it to custom list...<br/>we'll notify you if any similar info account is created</h6>
        </div><br/>
        <form action="" method="post" style="max-width: 550px;" enctype="multipart/form-data">

            <div class="form-group">
                <span style="display:block">Upload a Picture<br/>(Perdicts faster & better)</span>
                <label for="custompic" class="btn btn-outline-danger">Upload</label>
                <img id="output" src="" width="100px"><br>
                <input style="display: none;" type="file" onchange="loadFile(event)" name="custompic" id="custompic" accept="image/png, image/jpeg, image/gif">
                <script>
                    var loadFile = function(event) {
                        var output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        document.getElementById('output').style.display = "block";
                    };
                </script>
            </div>

            <div class="form-group">
                <label for="customName">Name:</label>
                <input required type="text" maxlength="45" class="form-control" id="customName" name="customName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="customCity">City:</label>
                <input required type="text" maxlength="45" class="form-control" id="customCity" name="customCity" placeholder="Which City">
            </div>

            <div>
                <a class="btn btn-outline-success" data-toggle="collapse" href="#customCollapse" role="button" aria-expanded="false" aria-controls="customCollapse">
                    I know more <i class="material-icons-outlined">keyboard_arrow_down</i>
                </a>
                <div class="collapse" id="customCollapse">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="customCollege">School/College:</label>
                            <input type="text" maxlength="45" class="form-control" id="customCollege" name="customCollege" placeholder="Which School?">
                        </div>
                        <div class="form-group">
                            <label for="customPhone">Phone:</label>
                            <input type="text" pattern="[0-9]{10}" class="form-control" id="customPhone" name="customPhone" placeholder="Contact Info">
                        </div>
                        <div class="form-group">
                            <label for="customBday">Birthday:</label>
                            <input type="date" min="1900-01-01" max="2025-12-31" class="form-control" id="customBday" name="customBday" placeholder="When is the B'day?">
                        </div>
                        <div class="form-group">
                            <label for="customInsta">Instagram username</label>
                            <input type="text" maxlength="45" class="form-control" id="customInsta" name="customInsta" placeholder="Insta user...">
                        </div>
                    </div>
                </div>
            </div><br/>
            <div align="center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <small id="emailHelp" class="form-text text-muted">We'll never share this info with anyone else.</small>
            </div>
        </form>
    </div><br/><br/><br/>

    <?php require_once('footer.php'); ?>