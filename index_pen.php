</head>
<style>
    #TTText {
        font-size: 9vw;
        color: #007bff;
        font-weight: bold;
    }
    .total {
        border-radius: 20px;
        margin: 10px;
    }
    .totalI {
        font-size: 40px;
    }
    #showSearchResult {
        max-width: 450px;
        border-radius: 15px;
        border: 1px solid #e6e6e6;
        padding: 10px;
        display: none;
    }
    .yo {
        border-radius: 20px;
        margin: 10px;
        box-shadow: 0 4px 8px #cccccc;
    }
    @media only screen and (max-width: 600px) { .yo { min-width: 75vw; } }
</style>
<body>

    <nav class="navbar navbar-light bg-light sticky-top">
        <a class="navbar-brand" href="#">
            <img src="img/welcome/logominout.png" height="30" alt="">
        </a>
        <div align="right">
            <a class="btn btn-outline-primary" href="login.php"><b>Log-in</b></a>
            <a class="btn btn-primary" href="register.php">Register</a>
        </div>
    </nav><br/>

    <div class="container bg-light" align="center">

        <p id="TTText">Third Law</p>
        <h5 style="color: #cccccc">
            Make private list of people you like and get match if they added you as well!
            Share expressions with next-gen messenging system!
        </h5><br/><br/>

        <form action="" style="max-width: 550px" onsubmit="return doit()">
            <div class="input-group mb-3">
                <input id="q" type="text" class="form-control" aria-label="Search anything" placeholder="Search people city ..." style="padding: 20px; border-top-left-radius: 50px; border-bottom-left-radius: 50px;">
                <div class="input-group-append">
                    <button class="input-group-text" style="width: 50px; padding: 8px; border-top-right-radius: 50px; border-bottom-right-radius: 50px;"><i class="material-icons-outlined">search</i></button>
                </div>
            </div>
        </form>
        <div id="showSearchResult" align="left"></div><br/>
        <script>
            function doit() {
                var q = $("#q").val();
                if(q != '') {
                    $("#showSearchResult").css("display", "block");
                    $.post("search.php?action=getuser&q=" + q, function(responce) {
                        $("#showSearchResult").html(responce);
                    });
                } else {
                    $("#showSearchResult").css("display", "none");
                }
                return false;
            }
        </script>

        <div>
            <a href="" class="btn btn-lg border-primary">
                <i class="material-icons-outlined text-danger">cloud</i>
                <b class="text-warning">Download</b>
                <i class="material-icons-outlined text-success">download</i>
            </a>
        </div><br/>

        <div class="row">
            <div class="col alert-light total">
                <?php
                    $sqlTotalUser = "SELECT id FROM users ORDER BY ID DESC LIMIT 1";
                    $resultTotalUser = $link->query($sqlTotalUser);
                    $rowTotalUser = mysqli_fetch_array($resultTotalUser);
                    echo '<h3><b>'.$rowTotalUser["id"].'</b></h3>';
                ?>
                <img src="img/start/user.png" width="50">
                <h5><b>Users</b></h5>
            </div>
            <div class="col alert-light total">
                <?php
                    $sqlTotalMessage = "SELECT id FROM message ORDER BY ID DESC LIMIT 1";
                    $resultTotalMessage = $link->query($sqlTotalMessage);
                    $rowTotalMessage = mysqli_fetch_array($resultTotalMessage);
                    echo '<h3><b>'.$rowTotalMessage["id"].'</b></h3>';
                ?>
                <img src="img/start/message.png" width="50">
                <h5><b>Expressions</b></h5>
            </div>
        </div><br/><br/>

        <div class="row">
            <div class="col">
                <div class="card yo alert-primary" id="crushDiv">
                    <div class="card-body">
                        <h4 class="card-title"><b>Crushes!</b></h4>
                        <h6>Secretly create a list of people you seem to like and if they add you as well you'll get a match. Later explore tips, places, styles to impress them!</h6>
                        <img src="img/start/crush.png" width="45">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card yo alert-warning" id="radarDiv">
                    <div class="card-body">
                        <h4 class="card-title"><b>Radar</b></h4>
                        <h6>Based on your Geolocation find people near you, or near person next house and add or message them!</h6>
                        <img src="img/start/radar.png" width="45">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card yo alert-danger" id="messageDiv">
                    <div class="card-body">
                        <h4 class="card-title"><b>Expressions!</b></h4>
                        <h6>With next-gen messenging, you can attach expressions with every message you send to give life to message. And keep a count of your emotions on the home screen</h6>
                        <img src="img/start/messageMain.png" width="45">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card yo alert-success" id="moreDiv">
                    <div class="card-body">
                        <h4 class="card-title"><b>Even more</b></h4>
                        <h6>Your passwords are encrypted, so no one even Third Law have direct access to it. If you feel anything is missing just contact down below</h6>
                        <img src="img/start/more.png" width="45">
                    </div>
                </div>
            </div>
        </div>

    </div><br/><br/><br/>

    <footer class="navbar bg-dark">
        <h6 class="text-primary"><b>Ishan Mathur &copy; Production</b></h6>
        <a class="btn text-primary" href="https:github.com/i5m/thirdlaw"><i class="material-icons-outlined">code</i><span style="display:block">Code</span></a>
    </footer>