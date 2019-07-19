<span id="forOnline"></span>
<script>
    $(document).ready(function() {
        $("#forOnline").load("onlinestatus.php");

        function blink() {
            $("#forOnline").load("onlinestatus.php");
        }
        setInterval(blink, 200000);
    });
</script>
<style>
    #menu {
        position: fixed;
        width: 100%;
        z-index: 1005;
    }
    .nav-link { color: #8c8c8c; }
    @media only screen and (min-width: 600px) {
        #menu { top: 0; border-bottom: 1px solid #d9d9d9; }
        ul { max-width: 600px; }
        .navWritten { font-size: 15px; }
        .activehai { border-bottom: 3px solid #007bff; color: #007bff; }
    }
    @media only screen and (max-width: 599px) {
        #menu { border-top: 1px solid #d9d9d9; bottom: 0;}
        .navWritten { font-size: 2vw; display: block; }
        .forNav { font-size: 6vw; }
        .activehai { color: #007bff; }
    }
    @media only screen and (max-width: 450px) {
        .navWritten { display: none; }
        .forNav { font-size: 8.5vw; }
    }
    @media only screen and (max-width: 250px) {
        .forNav { font-size: 6vw; }
    }
    nav div ul li #howManyMsg {
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 10px;
        background: #f5c6cb;
        color: #dc3545;
        font-weight: bold;
        text-align: center;
        font-size: 12px;
        top: 3px;
        right: 20px;
    }
</style>
<nav id="menu" class="navbar-light bg-light">
    <div align="center">
        <ul class="nav nav-fill">
            <li class="nav-item">
                <a class="nav-link" id="navHome" href="/"><i class="material-icons-outlined forNav">home</i> <b class="navWritten">Home</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navSearch" href="q.php"><i class="material-icons-outlined forNav">search</i> <b class="navWritten">Search</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navRadar" href="radar.php"><i class="material-icons-outlined forNav">whatshot</i> <b class="navWritten">Radar</b></a>
            </li>
            <li class="nav-item" style="position: relative;">
                <a class="nav-link" id="navMessage" href="message.php"><i class="material-icons-outlined forNav">textsms</i> <b class="navWritten">Chats</b></a>
                    <?php
                    if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true) {
                        $uu = $_SESSION["username"];
                        $sqlMsgNav = "SELECT count(hasseen) FROM message WHERE touser='$uu' AND hasseen=0";
                        $resultMsgNav = $link->query($sqlMsgNav);
                        $rowMsgNav = mysqli_fetch_array($resultMsgNav);

                        if($rowMsgNav["count(hasseen)"] == 0) { }
                        else if($rowMsgNav["count(hasseen)"] > 9) { echo '<div id="howManyMsg">9+</div>'; }
                        else { echo '<div id="howManyMsg">'.$rowMsgNav["count(hasseen)"].'</div>'; }
                    }
                    ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navProfile" href="my.php"><i class="material-icons-outlined forNav">account_circle</i> <b class="navWritten">Profile</b></a>
            </li>
        </ul>
    </div>
</nav>