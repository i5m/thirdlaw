<?php
require_once('header.php');
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { $u = $_SESSION["username"]; }
else { header("location: /"); exit; }

$sqlUser = "SELECT username, latest_lat, latest_lng, ploc, last_active FROM users WHERE username='$u'";
$resultUser = $link->query($sqlUser);
$rowUser = mysqli_fetch_array($resultUser);
?>
<script>
    if(screen.width > screen.height) {
        document.write('<style> #radarbg { width: auto; height: 90vh; top: 5%; right: 2%; } #searchingText { top: 50%; left: 15%; transform: translate(0, -50%); } </style>');
    }
    else {
        document.write('<style> #radarbg { width: 90vw; height: auto; top: 2%; left: 5%; } #searchingText { top: 75%; left: 50%; transform: translate(-50%, 0); } </style>');
    }
</script>
<style>
    @media only screen and (min-width: 600px) { #radarmainbox { margin-top: 45px; max-width: 350px; } }
    @media only screen and (max-width: 599px) { #radarmainbox { max-width: 100vw; } }
    #radarmainbox { width: 100%; z-index: 999; background: #FFFFFF; }
    #radarbg {
        position: fixed;
        z-index: -1;
        filter: opacity(0.7);
    }
    #searchingText {
        color: orange;
        z-index: -1;
        position: fixed;
    }
    
    #radarmainOpt {
        max-width: 100vw;
        z-index: 9990;
        padding: 15px;
        padding-bottom: 20px;
        width: 100%;
        color: #007bff;
        background: #FFFFFF;
        border-bottom: 1px solid #cccccc;
    }
    #radarmainOpt1, #radarmainOpt2 { position: absolute; }
    #radarmainOpt1 { left: 0; }
    #radarmainOpt2 { right: 2px; }
    #radarmainOpt button {
        border-radius: 30px;
        background: #f2f2f2;
    }
    @media only screen and (min-width: 600px) { #radarmainOpt { top: 46px; font-size: 22px; } }
    @media only screen and (max-width: 599px) { #radarmainbox { margin-top: 45vh; font-size: 5vw; } }
</style>
</head>
<body>
    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navRadar").addClass("activehai");
            $("#navRadar i").removeClass("material-icons-outlined");
            $("#navRadar i").addClass("material-icons");
        });
    </script>
    <img id="radarbg" src="img/home/radarbg.png">

    <div class="container-fluid">
        <div id="searchingText">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div id="radarmainbox" style="display: none;">
            
            <div id="radarmainOpt" class="sticky-top">
                <div id="radarmainOpt1">
                    <img src="img/welcome/radar.png" width="30px">
                    <b>People Nearby</b>
                </div>
                <div id="radarmainOpt2">
                    <button class="btn refresh">
                        <i class="material-icons-outlined">refresh</i>
                    </button>
                    <button type="button" class="btn" data-toggle="modal" data-target="#radarModal">
                        <i class="material-icons-outlined">info</i>
                    </button>
                </div><br/>
                <script>
                    $(document).ready(function(){
                        $(".refresh").click(function(){
                            $("#searchingText").css("display", "block");
                            $("#radarmainbox").css("display", "none");
                            setTimeout(function () {
                                $("#searchingText").css("display", "none");
                                $("#radarmainbox").css("display", "block");
                                $("#radarmainbox1").load("radar_main.php");
                            }, 2000);
                        });
                    });
                </script>
            </div>
            <div class="modal fade" id="radarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-body">
                        <div>
                            <div class="col">
                                
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <b>Done</b>
                        </button>
                    </div>
                    </div>
                </div>
            </div>

            <div id="radarmainbox1"></div>

        </div>
    </div>
    <script>
        $(document).ready(function(){
            setTimeout(function () {
                $("#searchingText").css("display", "none");
                $("#radarmainbox").css("display", "block");
                $("#radarmainbox1").load("radar_main.php");
            }, 2000);
        });
    </script>

<?php require_once('footer.php'); ?>