<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { header("location: /"); exit; }
else { $u = $_SESSION["username"]; }
require_once('header.php');
$navLeft = '<b style="font-size: 24px; vertical-align: middle;">Custom</b>';
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
        if ($_FILES["custompic"]["size"] > 500000) {
            echo "Sorry, the picture is too large.";
            $uploadOk = 0;
        }
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            $newfilename = $target_dir . $u . "_custom_" . md5($target_file) . '.' . $imageFileType;
            if (move_uploaded_file($_FILES["custompic"]["tmp_name"], $newfilename)) {
                $a = 1;
            } else {
                $a = 0;
                echo "Sorry, there was an error uploading your file." . "<br>";
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

            if (mysqli_stmt_execute($stmt)) { }
            else { echo "Error: " . $sql . "<br>" . $link->error; }
        }
    }

}

?>
<style>
    
</style>
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
                <img id="output" src="" style="display: none; max-width: 70vw; max-height: 70vh;"><br>
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
                <input required type="text" class="form-control" id="customName" name="customName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="customCity">City:</label>
                <input required type="text" class="form-control" id="customCity" name="customCity" placeholder="Which City">
            </div>

            <div>
                <a class="btn btn-outline-success" data-toggle="collapse" href="#customCollapse" role="button" aria-expanded="false" aria-controls="customCollapse">
                    I know more <i class="material-icons-outlined">keyboard_arrow_down</i>
                </a>
                <div class="collapse" id="customCollapse">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="customCollege">School/College:</label>
                            <input type="text" class="form-control" id="customCollege" name="customCollege" placeholder="Which School?">
                        </div>
                        <div class="form-group">
                            <label for="customPhone">Phone:</label>
                            <input type="text" class="form-control" id="customPhone" name="customPhone" placeholder="Contact Info">
                        </div>
                        <div class="form-group">
                            <label for="customBday">Birthday:</label>
                            <input type="date" min="1900-01-01" max="2025-12-31" class="form-control" id="customBday" name="customBday" placeholder="When is the B'day?">
                        </div>
                        <div class="form-group">
                            <label for="customInsta">Instagram username</label>
                            <input type="text" class="form-control" id="customInsta" name="customInsta" placeholder="Insta user...">
                        </div>
                    </div>
                </div>
            </div><br/>
            <div align="center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <small id="emailHelp" class="form-text text-muted">We'll never share this info with anyone else.</small>
            </div>
        </form>
    </div>

    <?php require_once('footer.php'); ?>