<?php
if (isset($_COOKIE["loggedin"])) {
    $u = $_COOKIE["username"];
} else {
    header("location: login.php");
    exit;
}

require_once('header.php');
$sql = "SELECT * FROM users WHERE username='$u'";
$result = $link->query($sql);
$row = mysqli_fetch_array($result);
if ($row["fullname"] == '' || $row["city"] == '') {
    header("location: finish.php");
    exit;
}
$navLeft = '<b style="font-size: 22px;">'.$u.'</b>';
?>

<style>
    @media only screen and (min-width: 600px) { .row { margin-top: 25px; } }
    @media only screen and (min-width: 768px) { #settings { max-width: 320px; border-radius: 10px; box-shadow: 0 2px 8px gray; }  }
    @media only screen and (max-width: 767px) { #settings { min-width: 80vw; width: 100%; margin-top: 25px; } }
    #info h3, #info p, #info h5 { margin-left: 20px; }
    #info p { color: gray; }
    #info h5 {
        max-width: 350px;
        margin: 5px;
        padding: 7px;
        color: gray;
        border-left: 1px solid #a6a6a6;
        border-radius: 10px;
    }
    #info .details {
        margin: 5px;
        padding: 5px;
        font-size: 18px;
    }
    .settingsBtn {
        margin: 5px;
        padding: 5px;
        font-size: 18px;
    }
    #settings .card {
        margin: 5px;
        padding: 5px;
        border-radius: 5px;
    }
    #settings .card h6, #settings .card a { color: gray; }
    #settings .card h3 { color: #007bff; }
    #settings .card a i { border-radius: 10px; padding: 2px; }
</style>
</head>

<body>

    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navProfile").addClass("activehai");
        });
    </script>

    <div class="container"><br><br>
        <div class="row">
            <div class="col" id="info">
                <div id="profilepic" style="background: url('<?php echo $row["ploc"]; ?>'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 140px; height: 140px; border-radius: 50%; border: 1px solid gray"></div><br>
                <h3><b><?php echo $row["fullname"]; ?></b></h3>
                <p>@<?php echo $u; ?></p>
                <h5>
                    <?php
                        if($row["bio"] != "") {
                            echo $row["bio"];
                        }
                        else { echo '<a class="btn btn-outline-dark" href="editprofile.php">Write about yourself <i class="material-icons-outlined">add</i></a>'; }
                    ?>
                </h5><br><br>
                
                <div class="details"><img src="img/profiledetails/color/city.png" width="35" height="auto"> &nbsp; <?php if($row["city"] != "") { echo "Lives in <b>" . $row["city"] . "</b>"; } else { echo '<a class="btn btn-outline-dark someSpecific" href="editprofile.php">Add City <i class="material-icons-outlined">add</i></a>'; } ?> </div>
                <div class="details"><img src="img/profiledetails/color/phone.png" width="35" height="auto"> &nbsp; <?php if($row["phone"] != "") { echo "Contact <b>" . $row["phone"] . "</b>"; } else { echo '<a class="btn btn-outline-dark someSpecific" href="editprofile.php">Add Phone <i class="material-icons-outlined">add</i></a>'; } ?> </div>
                <div class="details"><img src="img/profiledetails/color/college.png" width="35" height="auto"> &nbsp; <?php if($row["college"] != "") { echo "Studies at <b>" . $row["college"] . "</b>"; } else { echo '<a class="btn btn-outline-dark someSpecific" href="editprofile.php">Add Education <i class="material-icons-outlined">add</i></a>'; } ?> </div>
                <div class="details"><img src="img/profiledetails/color/bday.png" width="35" height="auto"> &nbsp; <?php if($row["bday"] != "") { echo "Wish on <b>" . $row["bday"] . "</b>"; } else { echo '<a class="btn btn-outline-dark someSpecific" href="editprofile.php">Add B\'day <i class="material-icons-outlined">add</i></a>'; } ?> </div>
                <div class="details"><img src="img/profiledetails/color/joined.png" width="35" height="auto"> &nbsp; <?php if($row["created_at"] != "") { echo "Joined on <b>" . substr($row["created_at"],0,10) . "</b>"; } else { } ?> </div>
                <div class="details"><img src="img/profiledetails/threeOpt/out/insta50.png" width="35" height="auto"> &nbsp; <?php if($row["instaprof"] != "") { echo "Instagram <b><a href='".$row["instaprof"]."'>" . $row["instaprof"] . "</a></b>"; } else { echo '<a class="btn btn-outline-dark someSpecific" href="editprofile.php">Add Instagram ID <i class="material-icons-outlined">add</i></a>'; } ?> </div>
                
            </div>
            <div id="settings" class="col"><br>
                <div class="card">
                    <h3><i class="material-icons-outlined">layers</i> <b>Stats</b></h3><br/>
                    <?php
                        $sqlCountVisit = "SELECT COUNT(whoprofile) FROM profiles WHERE whoprofile='$u'";
                        $resultCountVisit = $link->query($sqlCountVisit);
                        $rowCountVisit = mysqli_fetch_array($resultCountVisit);
                        $sqlCountOnMeCrush = "SELECT COUNT(user) FROM crushes WHERE crush='$u'";
                        $resultCountOnMeCrush = $link->query($sqlCountOnMeCrush);
                        $rowCountOnMeCrush = mysqli_fetch_array($resultCountOnMeCrush);
                        $sqlCountMyCrush = "SELECT COUNT(crush) FROM crushes WHERE user='$u'";
                        $resultCountMyCrush = $link->query($sqlCountMyCrush);
                        $rowCountMyCrush = mysqli_fetch_array($resultCountMyCrush);
                    ?>
                    <ul class="list-group">
                        <li class="list-group-item"><h6><img src="img/profiledetails/stat/recent.png" class="float-left mr-2" width="32px"> <b><?php echo $rowCountVisit["COUNT(whoprofile)"]; ?></b> people has visited your profile.</h6></li>
                        <li class="list-group-item"><h6><img src="img/profiledetails/stat/mine.png" class="float-left mr-2" width="32px"> You have crush on<b> <?php echo $rowCountMyCrush["COUNT(crush)"]; ?></b> people.</h6></li>
                        <li class="list-group-item"><h6><img src="img/profiledetails/stat/onMe.png" class="float-left mr-2" width="32px"> <b> <?php echo $rowCountOnMeCrush["COUNT(user)"]; ?> </b>people have crush on you</h6></li>
                    </ul>
                </div><br>
                <div class="card">
                    <h3><i class="material-icons-outlined">settings</i> <b>Settings</b></h3>
                    <div class="dropdown-divider"></div>
                    <a class="settingsBtn" href="editprofile.php"><b><i class="material-icons-outlined border p-1 mr-1">edit</i> Edit Profile</b></a>
                    <a class="settingsBtn" href="reset-password.php"><b><i class="material-icons-outlined border p-1 mr-1">fiber_pin</i> Reset Password</b></a>
                    <a class="settingsBtn" href="logout.php"><b><i class="material-icons-outlined border p-1 mr-1">power_settings_new</i> Logout</b></a>
                    <a class="settingsBtn" href="dev.php"><b><i class="material-icons-outlined border p-1 mr-1">code</i> DevOps</b></a>
                </div><br><br><br>
            </div>
        </div><br><br><br>
    </div>

    <?php require_once('footer.php'); ?>