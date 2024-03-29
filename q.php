<?php
if (isset($_COOKIE["loggedin"])) { $u = $_COOKIE["username"]; }
else { $u = ''; }
if (!empty($_GET)) { $q = $_GET['q']; }
require_once('header.php');
$navLeft = '<b style="font-size: 24px; vertical-align: middle;">Search</b>';
?>
<style>
    @media only screen and (min-width: 600px) {
        #searchBox { top: 45px; }
        .container { margin-top: 50px; }
    }
    #searchBox { padding: 7px; background:#fafafa; }
    .container { background: #fafafa; }
</style>
</head>

<body>

    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navSearch").addClass("activehai");
        });
    </script>

    <div align="center" id="searchBox" class="sticky-top">
        <form method='get'>
            <div style="max-width: 550px;">
                <input type="search" value="<?php if (!empty($_GET)) { echo $q; } ?>" class="form-control" style="border-radius: 50px; height: 40px;" placeholder="search..." name='q' id="q" aria-label="search" aria-describedby="basic-addon1">
            </div>
        </form>
        <div id="searchingIcon" style="display: none;">
            <div class="spinner-grow text-primary" style="width: 12px; height: 12px;" role="status"></div>
        </div>
        <!--<div>
            <ul class="nav nav-fill">
                <li class="nav-item">
                    <button id='homeBtn' class="btn searchTools" onclick="psh()"><i class="material-icons-outlined" style="color: gray; font-size: 30px;">person</i> </button>
                </li>
                <li class="nav-item">
                    <button id='phoneBtn' class="btn searchTools" onclick="bsh()"><i class="material-icons-outlined" style="color: gray; font-size: 30px;">phone</i> </button>
                </li>
                <li class="nav-item">
                    <button id='cityBtn' class="btn searchTools" onclick="psh()"><i class="material-icons-outlined" style="color: gray; font-size: 30px;">location_city</i> </button>
                </li>
                <li class="nav-item">
                    <button id='moreBtn' class="btn searchTools" onclick="bsh()"><i class="material-icons-outlined" style="color: gray; font-size: 30px;">info</i> </button>
                </li>
            </ul>
        </div>-->
    </div>

    <?php
    function plzSuggest() {
        if (isset($_COOKIE["loggedin"])) {
            $u = $_COOKIE["username"];
            $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            echo "<br><h4 style='color: gray'>Recent Searches: </h4>";
            $sqlSuggestSearch = "SELECT whosearch, searchfreq FROM searches WHERE username='" . $u . "' ORDER BY searched_at DESC";
            $resultSuggestSearch = $link->query($sqlSuggestSearch);
            if ($resultSuggestSearch->num_rows > 0) {
                $i = 0;
                while ($rowSuggestSearch = $resultSuggestSearch->fetch_assoc()) {
                    echo "<button style='color: gray' class='btn suggestBtn' value='".$rowSuggestSearch["whosearch"]."'>" . $rowSuggestSearch["whosearch"] . " &nbsp; <i class='material-icons-outlined' style='font-size: 15px; font-weight: bold;'>call_made</i></button><br>
                        <div class='dropdown-divider'></div>";
                    if($i == 3) { break; }
                    $i++;
                }
            }
        }
        echo "<img src='img/searchTools/bg.png' style='max-width: 400px; width: 90%; height: auto; position: fixed; bottom: 0; left: 50%; transform: translate(-50%, -50%); z-index: -99;'>";
    }
    ?>

    <div class="container">
        <div id="phpSug"><?php plzSuggest(); ?></div>
        <div align="center" id="customOption" style="display: none">
            <i class="material-icons-outlined" style="font-size: 50px;">pool</i>
            <h6> Hmm... Can't find anyone <br/> No worries... Add a custom one</h6>
            <a class="btn alert-primary" href="customuser.php" style="border-radius: 50px"><i class="material-icons-outlined">add</i> Add</a>
            <a class="btn btn-outline-dark" style="border-radius: 50px" data-toggle="collapse" href="#nooneCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">Know More</a>
            <div class="collapse" id="nooneCollapse">
                <br/><div class="card card-body">
                    <h6>If you can't find any person here add it to custom list...<br/>we'll notify you if any similar info account is created</h6>
                </div>
            </div>
        </div>
        <div id="userslist"></div>
    </div><br><br><br>

    <script>

        var typingTimer;
        var doneTypingInterval = 1500;
        var $q = $('#q');

        $q.on('keyup', function () {
            $("#searchingIcon").show();
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $q.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        function doneTyping () {
            $("#searchingIcon").hide();
            $("form").submit();
        }

        $(".suggestBtn").click(function(){
            $("#q").val($(this).val());
            $("form").submit();
        });

        $("form").submit(function() {
            var q = $("#q").val();
            if(q !== ""){
                $("#phpSug").hide();
                $.post("search.php?action=getuser&q=" + q, function(responce) {
                    if(responce === 'noone') {
                        $("#userslist").hide();
                        $("#customOption").show();
                    } else {
                        $("#customOption").hide();
                        $("#userslist").html(responce);
                        $("#userslist").show();
                    }
                });
            }
            else {
                $("#userslist").hide();
                $("#customOption").hide();
                $("#phpSug").show();
            }
            return false;
        });
    </script>

    <?php require_once('footer.php'); ?>