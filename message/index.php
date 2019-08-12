<?php
if (!isset($_COOKIE["loggedin"])) {
    header("location: /");
    exit;
} else {
    $u = $_COOKIE["username"];
}
require_once('../header.php');
if (!empty($_GET)) {
    $id = $_GET['id'];
} else {
    header("location: ../message.php");
}
?>
<?php
$sqlTo = "SELECT id, fullname, username, ploc, last_active FROM users WHERE id='$id'";
$resultTo = $link->query($sqlTo);
$rowTo = mysqli_fetch_array($resultTo);
if($rowTo["username"] == $u) { header("location: ../message.php"); exit; }
date_default_timezone_set('Asia/Kolkata');
$timeNow = Date("d-m-Y, H:i");
$timeNow = (strlen($timeNow) == 17) ? substr($timeNow, 0, 16) : $timeNow;
$lastOnline = $rowTo["last_active"];
$lastOnline = (strlen($lastOnline) == 17) ? substr($lastOnline, 0, 16) : $lastOnline;
$showOnline = "";
if($lastOnline == $timeNow) { $showOnline = '<svg width="14" height="14"><circle cx="7" cy="7" r="7" fill="#00ff00"/></svg>'; }
?>
<style>
    #topper {
        margin: 0;
        border-bottom: 1px solid #e6e6e6;
        padding: 5px;
        z-index: 1000;
    }
    #messageBox {
        position: fixed;
        bottom: 0;
        padding: 10px;
        width: 100%;
        z-index: 1000;
    }
    #messageBox form input { border-radius: 50px; }
    #messageBox form .btn { color: #007bff; }
    #emojiBar { width: 96%; overflow: auto; }
    #emojiBar button {
        float: left;
        width: 16%;
        text-align: center;
    }
    @media only screen and (min-width: 750px) {
        #chatBox {
            margin-left: 300px;
            width: calc(100% - 300px);
            border-left: 1px solid #a6a6a6;
        }
        #messageBox { width: calc(100% - 300px); }
        #extraOpt {
            max-width: 300px;
            position: fixed;
            left: 0;
            top: 15%;
        }
        #extraOpt .nav-link {
            margin-bottom: 20px;
            padding: 10px;
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
            width: 250px;
            text-align: center;
        }
    }
    #show {
        height: calc(100vh - 175px);
        overflow: auto;
        padding-bottom: 10px;
        background-color: #f2f2f2;
    }
    #show .myMsg, #show .thierMsg {
        margin: 7px;
        padding: 10px;
        padding-right: 25px;
        word-wrap: break-word;
        max-width: 300px;
        min-width: 100px;
        border-radius: 15px;
        text-align: left;
        position: relative;
    }
    #show .myMsg { border-bottom-right-radius: 0px; }
    #show .thierMsg { border-top-left-radius: 0px; }
    .showEmoji {
        position: absolute;
        top: 50%;
        left: 90%;
        transform: translate(-50%, -50%);
    }
    @media only screen and (max-width: 749px) {
        #extraOpt { display: none; }
        #topper { width: 100%; }
        #show .myMsg, #show .thierMsg { max-width: 75vw; }
    }
</style>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script>
    $(document).ready(function() {
        sO();
        setInterval(function() {
            sO();
        }, 200000);
        function sO() {
            $.post("../onlinestatus.php?action=stayOnline", function(responce) { });
        }
    });
</script>
</head>

<body>

    <div id="extraOpt"></div>
    <script>
        if (screen.width > 750) {
            document.getElementById("extraOpt").innerHTML =
                '<div align="center">' +
                '<img src="../<?php echo $rowTo["ploc"] ?>" width="90px">' +
                '<h3><b><?php echo $rowTo["fullname"]; ?></b></h3>' +
                '</div><br><br><br>' +
                '<a class="nav-link alert-dark" href="../users/welcome.php"><i class="material-icons-outlined">home</i> <b>Home</b></a>' +
                '<a class="nav-link alert-dark" href="../users/q.php"><i class="material-icons-outlined">search</i> <b>Search</b></a>' +
                '<a class="nav-link alert-dark" href="../users/message.php"><i class="material-icons-outlined">question_answer</i> <b>Chats</b></a>' +
                '<a class="nav-link alert-dark" href="../users/my.php"><i class="material-icons-outlined">account_circle</i> <b>Profile</b></a>';
        }
    </script>

    <div id="chatBox">

        <div id="topper" class="sticky-top bg-light">
            <table class="container-fluid bg-light">
                <td class="text-left">
                    <button class="btn" onclick="window.history.go(-1)">
                        <i class="material-icons-outlined">arrow_back</i> &nbsp; 
                        <b style="vertical-align: middle"><?php $nameTop = (strlen($rowTo["username"]) < 7) ? $rowTo["username"] : substr($rowTo["username"], 0, 7)."..."; echo $nameTop." ".$showOnline; ?></b>
                    </button>
                </td>
                <td class="text-right">
                    <div class="dropdown">
                        <button class="btn text-primary" type="button" id="ddBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <b>Mood</b> <i class="material-icons-outlined">keyboard_arrow_down</i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="button" class="btn dropdown-item" data-toggle="modal" data-target="#moodModal" value="like"><h5>Like</h5></button>
                            <button type="button" class="btn dropdown-item" data-toggle="modal" data-target="#moodModal" value="love"><h5>Love</h5></button>
                            <button type="button" class="btn dropdown-item" data-toggle="modal" data-target="#moodModal" value="haha"><h5>Funny</h5></button>
                            <button type="button" class="btn dropdown-item" data-toggle="modal" data-target="#moodModal" value="wow"><h5>Wow!</h5></button>
                            <button type="button" class="btn dropdown-item" data-toggle="modal" data-target="#moodModal" value="sad"><h5>Sad</h5></button>
                            <button type="button" class="btn dropdown-item" data-toggle="modal" data-target="#moodModal" value="angry"><h5>Angry</h5></button>
                        </div>
                    </div>
                </td>
            </table>
        </div>

        <div id="show_outer"><div id="show"></div><br/><br/><br/><br/></div>

        <div id="messageBox" class="bg-light">
            <form method="POST" id="messageBoxForm">
                <div class="input-group mb-3">
                    <input autocomplete="off" required type="text" class="form-control" aria-label="Start typing..." placeholder="Start typing..." name="theMessage" id="theMessage">
                    <div class="input-group-append">
                        <button class="btn theBtn" id="send"><i class="material-icons-outlined">send</i></button>
                    </div>
                </div>
                <ul class="nav nav-fill" id="emojiBar">
                    <button class="btn nav-link theBtn" id="like"><img src="../img/message/like.png"></button>
                    <button class="btn nav-link theBtn" id="love"><img src="../img/message/love.png"></button>
                    <button class="btn nav-link theBtn" id="haha"><img src="../img/message/haha.png"></button>
                    <button class="btn nav-link theBtn" id="wow"><img src="../img/message/wow.png"></button>
                    <button class="btn nav-link theBtn" id="sad"><img src="../img/message/sad.png"></button>
                    <button class="btn nav-link theBtn" id="angry"><img src="../img/message/angry.png"></button>
                </ul>
            </form>
        </div>

    </div>

    <div class="modal fade" id="moodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moodModalTitle"></h5>
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal" aria-label="Close">
                    <b>Done</b>
                </button>
            </div>
            <div class="modal-body">
                <div id="moodModalBody"></div>
            </div>
            </div>
        </div>
    </div>

    <script>
        var howreact = "";
        LoadMessage();
        setInterval(function() {
            LoadMessage();
        }, 2500);

        function LoadMessage() {
            $.post("handle.php?action=getMessage&touser=<?php echo $rowTo["username"]; ?>", function(responce) {

                var showH = $("#show").outerHeight(true);
                var scrollpos = $("#show").scrollTop();
                var scrollpos = parseInt(scrollpos) + showH;
                var scrollHeight = $("#show").prop('scrollHeight');

                $("#show").html(responce);

                if(scrollpos < scrollHeight){}
                else { $("#show").scrollTop($("#show").prop("scrollHeight")); }
            });
            $.post("handle.php?action=lastBg&touser=<?php echo $rowTo["username"]; ?>", function(responce){
                document.getElementById("show").style.backgroundColor = responce;
            });
        }
        $(".theBtn").click(function(e) {
            howreact = this.id;
        });
        $(".dropdown-item").click(function(){
            var theMood = $(this).val();
            $.post("handle.php?action=getMood&theMood="+theMood+"&touser=<?php echo $rowTo["username"]; ?>", function(responce) {
                $("#moodModalBody").html(responce);
                $("#moodModalTitle").html(theMood);
            });
        });
        $("#messageBoxForm").submit(function() {
            var theMessage = $("#theMessage").val();
            $.post("handle.php?action=sendMessage&howreact=" + howreact + "&touser=<?php echo $rowTo["username"]; ?>&theMessage=" + theMessage,
                function(responce) {
                    if(responce == 1) {
                        document.getElementById("messageBoxForm").reset();
                        LoadMessage();
                    }
                    $("#show").scrollTop($("#show").prop("scrollHeight"));
                });
                $.post("handle.php?action=lastBg&touser=<?php echo $rowTo["username"]; ?>", function(responce){
                    document.getElementById("show").style.backgroundColor = responce;
                });
            return false;
        });
    </script>

    <?php require_once('../footer.php'); ?>