<?php
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
    .quickText { display: block; }
    @media only screen and (max-width: 600px) {
        .quickText { font-size: 3vw; }
        .quickI { font-size: 8vw; }
    }
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
        });
    </script>

    <div class="container"><br/>

        <div id="userName">
            <b style="font-size: 30px; color: gray">Hi <?php $myName = explode(' ', $rowUser["fullname"]); $myName = $myName[0]; echo $myName; ?></b>
        </div>
        <div id="quick" class="m-3">
            <h6>Quick links:</h6>
            <ul class="nav nav-fill border rounded-lg">
                <li class="nav-item">
                    <a class="nav-link" href="#follow"><i class="material-icons-outlined quickI">favorite_border</i> <span class="quickText">Crushes</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#howreact"><i class="material-icons-outlined quickI">thumbs_up_down</i> <span class="quickText">Chats</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#radar"><i class="material-icons-outlined quickI">near_me</i> <span class="quickText">Radar</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#visitedProfile"><i class="material-icons-outlined quickI">history</i> <span class="quickText">Recents</span></a>
                </li>
            </ul>
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