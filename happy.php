<?php
if (isset($_COOKIE["loggedin"])) {
    $u = $_COOKIE["username"];
}
else {
    header("location: login.php");
    exit;
}
$theIp = $_SERVER['REMOTE_ADDR'];
$usingGeo = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lat = $_POST["laty"];
    $lon = $_POST["lony"];
    $usingGeo = 1;
} else {
    $ipApi = 'http://ip-api.com/json/' . $theIp;
    $ipJson = @file_get_contents($ipApi);
    if ($ipJson !== FALSE) {
        $readIpJson = @json_decode($ipJson, true);
        if ($readIpJson !== FALSE) {
            $lat = $readIpJson['lat'];
            $lon = $readIpJson['lon'];
        }
    }
}

//https://places.cit.api.here.com/places/v1/discover/explore?app_id=pwz1ULj9VFFYDbS5I15f&app_code=flvCBcEyLKtphLzlv7r1Ow&at=26.474472,74.637917&pretty

$sqlUser = "SELECT id, fullname, city, username, bday, college FROM users WHERE username='$u'";
$resultUser = $link->query($sqlUser);
$rowUser = mysqli_fetch_array($resultUser);
$navLeft = '<i class="material-icons-outlined">place</i> <b style="font-size: 25px; vertical-align: middle;">Explore</b>';
?>