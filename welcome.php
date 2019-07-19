<?php
    $theIp = '117.225.94.38';
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
    if ($rowUser["fullname"] == '' || $rowUser["city"] == '') {
        header("location: finish.php");
        exit;
    }
    $navLeft = '<img src="img/home/tl.png" height="30px">';
?>
<style>
    @media only screen and (min-width: 430px) { #userName { margin-top: 25px; } }
    #userName { max-width: 300px; min-width: 200px; }
    #openweathermap {
        max-width: 400px;
        min-width: 280px;
        box-shadow: 0 2px 6px #d9d9d9;
        position: relative;
        margin: 10px;
        border-radius: 7px;
        text-align: center;
    }
    #openweathermap table td { max-width: 150px; width: 33%; color: gray; }
    #radarKnowBtn, #radarFindBtn, #crushKnowBtn, #reactKnowBtn, #follow div a { margin: 5px; }
    #howreact, #suggestion { margin-bottom: 40px; }
    .welcomeTopics { font-size: 30px; color: #333333; }
</style>
</head>

<body>

    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navHome").addClass("activehai");
            $("#navHome img").attr("src", "img/nav/ahome.svg");
        });
    </script>

    <div class="container"><br/>
        <div class="row">
            <div class="col" id="userName">
                <b style="font-size: 30px; color: gray">Hi <?php $myName = explode(' ', $rowUser["fullname"]); $myName = $myName[0]; echo $myName; ?></b>
            </div>
            <div class="col" id="openweathermap">
                <?php
                if($readIpJson !== FALSE) {
                    $weatherApi = "http://api.openweathermap.org/data/2.5/weather?lat=".$lat."&lon=".$lon."&APPID=22d5874ea9331099d9ad4e28875a7ef6";
                    $weatherJson = @file_get_contents($weatherApi);
                    if($weatherJson !== FALSE) {
                        $readWeatherJson = @json_decode($weatherJson, true);
                        if($readWeatherJson !== FALSE) {
                            $temp_cel = $readWeatherJson["main"]["temp"] - 273.15;
                            $temp_cel = substr($temp_cel,0,4);
                            echo '<table class="bg-light" align="center">
                                    <td class="align-middle text-left">
                                        <p class="text-uppercase">'.$readWeatherJson["weather"][0]["description"].'</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <img src="img/weather/'.$readWeatherJson["weather"][0]["icon"].'-min.png" width="60px">
                                    </td>
                                    <td class="align-middle text-right">
                                        <p>'.$temp_cel.' °C</p>
                                    </td>
                                </table>';
                        }
                    }
                }
                ?>
            </div>
        </div><br/>

        <div id="follow">
            <?php require_once('welcome/crush.php'); ?>
        </div>
        <br/><div class="dropdown-divider"></div><br/>
        <div class="row">
            <div class="col" id="howreact">
                <?php require_once('welcome/howreact.php'); ?>
            </div>
            <br/><div class="dropdown-divider"></div><br/>
            <div class="col" id="radar">
                <?php require_once('welcome/radar.php'); ?>
            </div>
        </div>
        <br/><div class="dropdown-divider"></div><br/>
        <div class="row" align="center">
            <div class="col" id="suggestion">
                <?php /*require_once('welcome/sug.php');*/ ?>
            </div>
            <br/><div class="dropdown-divider"></div><br/>
            <div class="col" id="visitedProfile">
                <?php require_once('welcome/visited.php'); ?>
            </div>
        </div>
        <br/><div class="dropdown-divider"></div><br/>
        <div class="modal fade" id="knowmore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body" align="center">
                        <h3><b id="knowhead"></b></h3>
                        <div id="knowbody"></div><br/>
                        <button type="button" class="btn text-primary" data-dismiss="modal">
                            <b>Got it!</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>    
    </div><br/><br/><br/>