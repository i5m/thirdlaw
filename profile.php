<?php
if(isset($_GET['id'])) { $id = $_GET['id']; }
else { header("location: q.php"); exit; }
if (isset($_COOKIE["loggedin"])) { $u = $_COOKIE["username"]; }
else { $u = ''; }

require_once('header.php');
$sql = "SELECT * FROM users WHERE id='$id'";
$result = $link->query($sql);
$row = mysqli_fetch_array($result);
$navLeft = '<button class="btn" onclick="history.go(-1)"><i class="material-icons-outlined" style="font-weight: bold; vertical-align: top; color: #007bff;">arrow_back</i></button> <b style="font-size: 18px;">@'.$row["username"].'</b>';
?>

<?php
$sqlprofileExist = "SELECT username, whoprofile, profilefreq FROM profiles WHERE username='" . $u . "' AND whoprofile='" . $row["username"] . "'";
$resultprofileExist = $link->query($sqlprofileExist);
$rowprofileExist = mysqli_fetch_array($resultprofileExist);
if ($resultprofileExist->num_rows > 0) {
    $incr = $rowprofileExist["profilefreq"];
    $incr = $incr + 1;
    $sqlprofile = "UPDATE profiles SET profilefreq=$incr WHERE username='$u' AND whoprofile='" . $row["username"] . "'";
}
else { $sqlprofile = "INSERT INTO profiles (username, whoprofile) VALUES ('$u', '" . $row["username"] . "')"; }
if ($link->query($sqlprofile) != TRUE) { echo "Error: " . $sqlprofile . "<br>" . $link->error; }
?>

<style>
    @media only screen and (min-width: 600px) {
        .container { margin-top: 25px; }
        #profilepic { max-width: 250px; }  
        #about { margin-top: 25px; }
        #threeOptBox {
            position: absolute;
            bottom: 10px;
            right: 20px;
            width: 380px;
        }
        #threeOptBox .btn {
            display: block;
            width: 360px;
            margin: 10px;
            box-shadow: 0 2px 6px #a6a6a6;
        }
        #threeOptBox .btn img { width: 50px; }
        #threeOptBox .btn .colone { max-width: 80px;}
    }
    @media only screen and (max-width: 599px) {
        #about { min-width: 70vw; }
        #threeOptBox .btn img { width: 15vw; }
        #threeOptBox .btn .coltwo { display: none; }
    }
    #threeOptBox .btn { filter: opacity(0.7); }
    #threeOptBox .btn img {
        padding: 10px;
        border-radius: 50px;
        background: #e6e6e6;
        margin: 7px;
    }
    #info #about h3, #info #about p, #info #about h5 { margin-left: 20px; }
    #info #about p { color: gray; }
    #info #about h5 {
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
</style>
</head>

<body>

    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navSearch").addClass("activehai");
        });
    </script>

    <div class="container"><br><br>
        <div id="info">
            <div class="row">
                <div id="profilepic" class="col">
                    <div style="background: url('<?php echo $row["ploc"]; ?>'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 140px; height: 140px; border-radius: 50%; border: 1px solid gray"></div><br>
                </div>
                <div class="col" id="about">
                    <h3><b><?php echo $row["fullname"]; ?></b></h3>
                    <p>@<?php echo $row["username"]; ?></p>
                    <h5>
                        <?php
                            if($row["bio"] != "") { echo $row["bio"]; }
                        ?>
                    </h5>
                </div>
            </div><br>

            <?php
            if (!isset($_COOKIE["loggedin"])) {
                echo '<a class="btn btn-outline-primary" href="login.php">
                        <i class="material-icons-outlined">favorite_border</i> &nbsp; Add Crush &nbsp; <i class="material-icons-outlined">add</i>
                        <span style="display: block; font-size: 10px;">Log in</span>
                    </a>';
            }
            else {
                $sqlCheck = "SELECT user, crush FROM crushes WHERE user='$u' AND crush='".$row["username"]."'";
                $resultCheck = $link->query($sqlCheck);
                if($row["username"] === $u) { echo 'You already are seeing you 😂😂😂<br/>'; }
                else if ($resultCheck->num_rows > 0) {
                    $sqlRevCrush0 = "SELECT crush FROM crushes WHERE user='$u' AND crush='".$row["username"]."'";
                    $sqlRevCrush1 = "SELECT crush FROM crushes WHERE user='".$row["username"]."' AND crush='$u'";
                    $resultRevCrush0 = $link->query($sqlRevCrush0);
                    $resultRevCrush1 = $link->query($sqlRevCrush1);
                    if ($resultRevCrush0->num_rows > 0 && $resultRevCrush1->num_rows > 0) {
                        echo '<form action="adjustcrush.php" method="post">
                            <a href="happy.php" class="btn alert-primary">
                                <i class="material-icons-outlined">category</i> &nbsp; Match<br>
                            </a>
                            <input value="' . $row["username"] . '" style="display: none;" name="myCrush">
                            <button class="btn btn-danger" type="submit" name="deleteCrushBtn">
                                <i class="material-icons-outlined">delete</i>
                            </button>
                        </form>';
                    }
                    else {
                        echo '<form action="adjustcrush.php" method="post">
                                <div class="btn alert-warning">
                                    <i class="material-icons-outlined">favorite_border</i> &nbsp; Added
                                </div>
                                <input value="' . $row["username"] . '" style="display: none;" name="myCrush">
                                <button class="btn btn-danger" type="submit" name="deleteCrushBtn">
                                    <i class="material-icons-outlined">delete</i>
                                </button>
                            </form>';
                    }
                }
                else {
                    echo '<form action="adjustcrush.php" method="post">
                            <input value="' . $row["username"] . '" style="display: none;" name="myCrush">
                            <button class="btn btn-primary" type="submit" name="addCrushBtn">
                                <i class="material-icons-outlined">favorite_border</i> &nbsp; Add Crush &nbsp; <i class="material-icons-outlined">add</i>
                            </button>
                        </form>';
                }
            }
            ?><br>

            <div id="threeOptBox" align="center">

                <?php
                $sqlCountCrush = "SELECT COUNT(user) FROM crushes WHERE crush='".$row["username"]."'";
                $resultCountCrush = $link->query($sqlCountCrush);
                $rowCountCrush = mysqli_fetch_array($resultCountCrush);
                if ($rowCountCrush["COUNT(user)"] > 0) {
                    echo '<button type="button" class="btn" id="crushThreeOpt" data-toggle="modal" data-target="#crushModal">
                            <div class="row">
                                <div class="col colone">
                                    <img src="img/profiledetails/threeOpt/out/crush50.png"><br/>
                                    <b>Crushes</b>
                                </div>
                                <div class="col my-auto coltwo">
                                    <b>Find out how many people has crush on '.$row["fullname"].'</b>
                                </div>
                            </div>
                        </button>
                        <div class="modal fade" id="crushModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-body">
                                    <b style="font-size: 80px;">'.$rowCountCrush["COUNT(user)"].'</b>
                                    <h4>People have crush on '.$row["fullname"].'</h4><br/>
                                    <p style="color: gray">
                                        <b>Disclaimer</b>: This is just the <b>NUMBER</b> of people who have added  '.$row["fullname"].' on thier list. 
                                        There is no way that thier identities are revealed by this figure
                                    </p><br/>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <b>Done</b>
                                    </button>
                                </div>
                                </div>
                            </div>
                        </div>';
                }
                ?>

                <a class="btn" id="messageThreeOpt" href="message?id=<?php echo $row["id"]; ?>">
                    <div class="row">
                        <div class="col colone">
                            <img src="img/profiledetails/threeOpt/out/message50.png"><br/>
                            <b>Chat</b>
                        </div>
                        <div class="col my-auto coltwo">
                            <b>Chat with <?php echo $row["fullname"]; ?> & share memories or plan an event</b>
                        </div>
                    </div>
                </a>

                <?php
                    if($row["instaprof"] !== "") {
                        echo '<a class="btn" id="instaThreeOpt" href="https://instagram.com/'.$row["instaprof"].'">
                                <div class="row">
                                    <div class="col colone">
                                        <img src="img/profiledetails/threeOpt/out/insta50.png"><br/>
                                        <b>Insta</b>
                                    </div>
                                    <div class="col my-auto coltwo">
                                        <b>Find '.$row["fullname"].' on Instagram<br/>and check out photos & stories</b>
                                    </div>
                                </div>
                            </a>';
                    }
                ?>

            </div><br>
               
            <?php if($row["city"] != "") { echo '<div class="details"><img src="img/profiledetails/color/city.png" width="35" height="auto"> &nbsp;' . "Lives in <b>" . $row["city"] . "</b>" . '</div>'; } ?>
            <?php if($row["phone"] != "") { echo '<div class="details"><img src="img/profiledetails/color/phone.png" width="35" height="auto"> &nbsp;' . "Contact <b>" . $row["phone"] . "</b>" . '</div>'; } ?>
            <?php if($row["college"] != "") { echo '<div class="details"><img src="img/profiledetails/color/college.png" width="35" height="auto"> &nbsp;' . "Studies at <b>" . $row["college"] . "</b>" . '</div>'; } ?>
            <?php if($row["bday"] != "") { echo '<div class="details"><img src="img/profiledetails/color/bday.png" width="35" height="auto"> &nbsp;' . "Wish on <b>" . $row["bday"] . "</b>" . '</div>'; } ?>
            <?php if($row["created_at"] != "") { echo '<div class="details"><img src="img/profiledetails/color/joined.png" width="35" height="auto"> &nbsp;' . "Joined on <b>" . substr($row["created_at"],0,10) . "</b>" . '</div>'; } ?>
            
        </div>
        <br><br><br>
    </div>

    <?php require_once('footer.php'); ?>