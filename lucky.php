<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$u = $_SESSION["username"];

$theIp = 'https://places.cit.api.here.com/places/v1/discover/explore?app_id=pwz1ULj9VFFYDbS5I15f&app_code=flvCBcEyLKtphLzlv7r1Ow&at=26.474472,74.637917&pretty';
$ipApi = 'http://ip-api.com/json/'.$theIp;
$ipJson = @file_get_contents($ipApi);
if($ipJson !== FALSE) {
    $readIpJson = @json_decode($ipJson, true);
    if($readIpJson !== FALSE) {
        $lat = $readIpJson['lat'];
        $lon = $readIpJson['lon'];
        $sqlSetLatLng = "UPDATE users SET latest_lat='$lat', latest_lng='$lon', theIp='$theIp' WHERE username='$u'";
        if ($link->query($sqlSetLatLng) !== TRUE) { echo "Error updating record: " . $link->error; }
    }
}

$sqlUser = "SELECT id, fullname, city, username, bday, college FROM users WHERE username='$u'";
$resultUser = $link->query($sqlUser);
$rowUser = mysqli_fetch_array($resultUser);
$navLeft = '<i class="material-icons-outlined">place</i> <b style="font-size: 25px; vertical-align: middle;">Explore</b>';
?>