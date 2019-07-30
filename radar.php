<?php
require_once('header.php');
if (isset($_COOKIE["loggedin"])) { $u = $_COOKIE["username"]; }
else { header("location: /"); exit; }

$sqlUser = "SELECT username, latest_lat, latest_lng, ploc, last_active FROM users WHERE username='$u'";
$resultUser = $link->query($sqlUser);
$rowUser = mysqli_fetch_array($resultUser);

$theIp = '157.38.0.75';

date_default_timezone_set('Asia/Kolkata');
$isOnline = Date("d-m-Y, H:i");
$isOnline = (strlen($isOnline) == 17) ? substr($isOnline, 0, 16) : $isOnline;
$showNa = 0;
$howmany = 0;
$usingGeo = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lat = $_POST["laty"];
    $latest_lat = (strlen($lat) > 5) ? substr($lat, 0, 5) : $lat;
    $lon = $_POST["lony"];
    $latest_lon = (strlen($lon) > 5) ? substr($lon, 0, 5) : $lon;
    $usingGeo = 1;
    $showNa = 1;
}
else {
    $ipApi = 'http://ip-api.com/json/' . $theIp;
    $ipJson = @file_get_contents($ipApi);
    if ($ipJson !== FALSE) {
        $readIpJson = @json_decode($ipJson, true);
        if ($readIpJson !== FALSE) {
            $lat = $readIpJson['lat'];
            $latest_lat = (strlen($lat) > 5) ? substr($lat, 0, 5) : $lat;
            $lon = $readIpJson['lon'];
            $latest_lon = (strlen($lon) > 5) ? substr($lon, 0, 5) : $lon;
            $showNa = 1;
        }
    }
}
if($showNa == 1) {
    $sqlSetLatLng = "UPDATE users SET latest_lat='$lat', latest_lng='$lon', theIp='$theIp' WHERE username='$u'";
    if ($link->query($sqlSetLatLng) !== TRUE) { echo "Error updating record: " . $link->error; }
}
$navLeft = '<b style="font-size: 22px;"><button type="button" class="btn" data-toggle="modal" data-target="#radarModal"><i class="material-icons-outlined" style="color: #007bff;">info</i> </button> Radar</b>';
?>
<style>
    @media only screen and (min-width: 600px) {
        #radartop {
            top: 45%;
            left: 75%;
            transform: translate(-50%, -50%);
        }
        #radarbg { width: 20vw; }
    }
    @media only screen and (max-width: 599px) {
        #radartop {
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        #radarbg { width: 40vw; }
    }
    #radartop {
        position: fixed;
        z-index: -1;
        filter: opacity(0.5);
    }
    #radarbg { transition: width 2s; }
    .preSpinner {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    @media only screen and (min-width: 600px) { #radarbox { margin-top: 45px; max-width: 350px; } }
    #radarbox {
        width: 100%;
        z-index: 999;
        background: #FFFFFF;
        position: relative;
    }
    #radarOpt button { border-radius: 30px; background: #e6e6e6; }
    @media only screen and (max-width: 599px) { #radarbox { margin-top: 45vh; } }
    .alert {
        position: relative;
        margin: 10px;
        padding: 10px;
        box-shadow: 0 1px 5px #d9d9d9;
    }
    #raadarModal { color: gray; }
    #radarModal i { font-size: 35px; }
</style>
</head>
<body>
    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navRadar").addClass("activehai");
        });
    </script>

    <div class="container">

        <div id="radarbox">

            <div class="preSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div id="radarUsers" style="display: none;">
                <?php
                if ($showNa == 1) {
                    if($usingGeo == 0) {
                        echo '<br><div id="radarOpt3" align="center">
                                <a class="btn btn-outline-success" href="https://i5m.github.io/geoloc.html">
                                    Show result by Geolocation
                                </a>
                            </div><br>';
                    }
                    else if($usingGeo == 1) {
                        echo '<br><div id="radarOpt3" align="center">
                                <a class="btn btn-outline-danger" href="http://chance.rf.gd/radar.php">
                                    Search based on IP
                                </a>
                            </div><br>';
                    }
                    /*last_active LIKE '$isOnline%' AND*/
                    $sqlNearMe = "SELECT id, username, fullname, ploc, last_active FROM users WHERE
                                            latest_lat LIKE '$latest_lat%' AND
                                            latest_lng LIKE '$latest_lon%' AND
                                            NOT username='$u'
                                            ORDER BY last_active DESC";
                    $resultNearMe = $link->query($sqlNearMe);
                    if ($resultNearMe->num_rows > 0) {
                        while ($rowNearMe = $resultNearMe->fetch_assoc()) {
                            $lastOnline = $rowNearMe["last_active"];
                            $lastOnline = (strlen($lastOnline) == 17) ? substr($lastOnline, 0, 16) : $lastOnline;
                            if($lastOnline == $isOnline) { $qOnline = '00ff00'; }
                            else { $qOnline = 'd9d9d9'; }
                            echo '<div class="alert">
                                    <a href="profile.php?id=' . $rowNearMe["id"] . '">
                                        <div class="media">
                                            <div class="mr-3" style="border-radius: 50px; border: 1px solid gray; width: 50px; height: 50px; background: url(' . $rowNearMe["ploc"] . '); background-size: cover;" id="profilepic"></div>
                                            <div class="media-body">
                                                <h6><b style="color: black">' . $rowNearMe["fullname"] . '</b><span style="color: gray; display: block;">@' . $rowNearMe["username"] . '</span></h6>
                                            </div>
                                            <div style="position: absolute; right: 10px; top: 18px;">
                                                <svg width="14" height="14">
                                                    <circle cx="7" cy="7" r="7" fill="#'.$qOnline.'"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                </div>';
                            $howmany++;
                        }
                    } else {
                        echo '<br><br><h4 align="center">No user found near you :(</h4>
                            <p style="color: gray;" align="center">Either refresh or wait for some minutes.</p>';
                    }
                } else {
                    echo '<br><br><p align="center">You might have problem with your internet connection :(</p>';
                }
                ?>
            </div><br><br><br>           

        </div>

        <div class="modal fade" id="radarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">
                        <i class="material-icons-outlined">whatshot</i> <b> Radar</b>
                    </h4>
                </div>
                <div class="modal-body">
                    <table class="table" style="color: gray">
                        <tbody>
                            <tr>
                                <td><i class="material-icons-outlined">help_outline</i></td>
                                <td><b>Based on your IP Address, the algorithm finds out location of you and people nearby.</b></td>
                            </tr>
                            <tr>
                                <td><i class="material-icons-outlined">swap_vertical_circle</i></td>
                                <td>
                                    <b>Users are sorted on the basis of thier last active session.</b><br/>
                                    <svg width="14" height="14">
                                        <circle cx="7" cy="7" r="7" fill="#00ff00"/>
                                    </svg>
                                    <b>User Online</b><br/>
                                    <svg width="14" height="14">
                                        <circle cx="7" cy="7" r="7" fill="#d9d9d9"/>
                                    </svg>
                                    <b>User Offline</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <b>Done</b>
                    </button>
                </div>
                </div>
            </div>
        </div>

    </div>

    <div id="radartop">
        <div align="center">
            <img id="radarbg" src="img/home/network.svg">
            <div id="howmany" style="display: none;">
                <b style="font-size: 70px;"><?php echo $howmany; ?></b>
                <h4><b>people found near you</b></h4>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            setTimeout(function () {
                $(".preSpinner").css("display", "none");
                $("#radarUsers").css("display", "block");
                $("#radarbg").css("width", "15vw");
                $("#howmany").fadeIn(2000);
            }, 1500);
        });
    </script>

<?php require_once('footer.php'); ?>