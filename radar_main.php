<?php
require_once('config.php');
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { $u = $_SESSION["username"]; }
else { header("location: /"); exit; }

$sqlUser = "SELECT username, latest_lat, latest_lng, ploc, last_active FROM users WHERE username='".$_SESSION["username"]."'";
$resultUser = $link->query($sqlUser);
$rowUser = mysqli_fetch_array($resultUser);

date_default_timezone_set('Asia/Kolkata');
$isOnline = Date("d-m-Y, H:i");
$isOnline = (strlen($isOnline) == 17) ? substr($isOnline, 0, 16) : $isOnline;

$theIp = '157.38.0.75';
$ipApi = 'http://ip-api.com/json/' . $theIp;
$ipJson = @file_get_contents($ipApi);
if ($ipJson !== FALSE) {
    $readIpJson = @json_decode($ipJson, true);
    if ($readIpJson !== FALSE) {
        $lat = $readIpJson['lat'];
        $latest_lat = (strlen($lat) > 5) ? substr($lat, 0, 5) : $lat;
        $lon = $readIpJson['lon'];
        $latest_lon = (strlen($lon) > 5) ? substr($lon, 0, 5) : $lon;
        $region_name = $readIpJson['regionName'] . ", " . $readIpJson["countryCode"];
        $sqlSetLatLng = "UPDATE users SET latest_lat='$lat', latest_lng='$lon', theIp='$theIp' WHERE username='$u'";
        if ($link->query($sqlSetLatLng) !== TRUE) {
            echo "Error updating record: " . $link->error;
        }
    }
}
?>
<style>
    .alert {
        margin: 10px;
        padding: 10px;
        border-radius: 15px;
        box-shadow: 0 1px 5px #cccccc;
    }
</style>
<div id="radarmainUsers">
    <?php
    /*last_active LIKE '$isOnline%' AND*/
    $sqlNearMe = "SELECT id, username, fullname, ploc, last_active FROM users WHERE
                            latest_lat LIKE '$latest_lat%' AND
                            latest_lng LIKE '$latest_lon%' AND
                            NOT username='$u'";
    $resultNearMe = $link->query($sqlNearMe);
    if ($resultNearMe->num_rows > 0) {
        while ($rowNearMe = $resultNearMe->fetch_assoc()) {
            $lastOnline = $rowNearMe["last_active"];
            $lastOnline = (strlen($lastOnline) == 17) ? substr($lastOnline, 0, 16) : $lastOnline;
            if($lastOnline == $isOnline) {
                $qOnline = '<div class="col align-middle">
                                <svg width="14" height="14">
                                    <circle cx="7" cy="7" r="7" fill="#00ff00"/>
                                </svg>
                            </div>';
            }
            else { $qOnline = ''; }
            echo '<div class="alert">
                    <a href="profile.php?id=' . $rowNearMe["id"] . '">
                        <div class="row">
                            <div class="col" style="margin-left: 5px; max-width: 60px;">  
                                <div style="border-radius: 50px; border: 1px solid gray; width: 50px; height: 50px; background: url(' . $rowNearMe["ploc"] . '); background-size: cover;" id="profilepic"></div>
                            </div>
                            <div class="col align-middle">
                                <h6><b style="color: black">' . $rowNearMe["fullname"] . '</b><span style="color: gray; display: block;">@' . $rowNearMe["username"] . '</span></h6>
                            </div>'.$qOnline.'
                        </div>
                    </a>
                </div>';
        }
    } else {
        echo '<h4 style="color: red;">No user found near you :(</h4>
            <p style="color: gray;">Either refresh or wait for some minutes.</p>';
    }
    ?>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
    <h1>cajinijnjn<br>dn ijnj ksd</h1>
</div><br><br><br>