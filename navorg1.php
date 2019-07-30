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
        ul { max-width: 450px; }
        .navWritten { font-size: 15px; }
        .forNav { width: 22px; }
        .activehai { border-bottom: 3px solid #007bff; color: #007bff; }
    }
    @media only screen and (max-width: 599px) {
        #menu { border-top: 1px solid #d9d9d9; bottom: 0; box-shadow: 0 -1px 2px #e6e6e6; }
        .nav-link { padding-top: 12px; padding-bottom: 12px; }
        .navWritten { font-size: 2vw; display: block; }
        .forNav { width: 4vw; }
    }
    @media only screen and (max-width: 450px) {
        .navWritten { display: none; }
        .forNav { width: 7.5vw; }
    }
    @media only screen and (max-width: 270px) {
        .forNav { width: 4vw; }
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

    <script>
        if(screen.width > 600){ document.write('<img src="img/welcome/logomin.png" style="width: 35px; position: absolute; top: 5px; left: 5px;">'); }
        if(screen.width > 800 && window.location.pathname !== '/q.php') {
            document.write('<form action="q.php" method="get">' +
                '<div class="input-group" style="position: fixed; top: 3px; left: 55px; width: 35vw;">' +
                    '<input style="border-radius: 50px; border: none; background: #e6e6e6;" type="text" class="form-control" placeholder="Search..." aria-describedby="basic-addon2" name="q">' +
                    '<divclass="input-group-append>' +
                        '<span class="input-group-text ml-1" style="border-radius: 50px;" id="basic-addon2"><i class="material-icons-outlined">search</i></span>' +
                    '</div>' +
                '</div>' +
            '</form>'); }
        else if(screen.width > 600 && screen.width < 800 && window.location.pathname !== '/q.php') {
            document.write('<a style="position: fixed; top: -3px; left: 55px;" class="btn ml-2" id="navSearch" href="q.php">' +
                            '<img src="img/nav/search.svg">' +
                            '<b style="display: block; font-size: 10px; color: #000000">Search</b>' +
                        '</a>');
        }
    </script>

    <div align="right">
        <ul class="nav nav-fill">
            <li class="nav-item">
                <a class="nav-link" id="navHome" href="/"><img class="forNav" src="img/nav/home.svg"> <b class="navWritten">Home</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navRadar" href="radar.php"><img class="forNav" src="img/nav/radar.svg"> <b class="navWritten">Radar</b></a>
            </li>
            <li class="nav-item" style="position: relative;">
                <a class="nav-link" id="navMessage" href="message.php"><img class="forNav" src="img/nav/message.svg"> <b class="navWritten">Chats</b></a>
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
                <a class="nav-link" id="navProfile" href="my.php"><img class="forNav" src="img/nav/profile.svg"> <b class="navWritten">Profile</b></a>
            </li>
        </ul>
    </div>
</nav>

<script>
    if(screen.width < 600 && window.location.pathname !== '/q.php'){
        document.write('<div class="sticky-top bg-light" style="box-shadow: 0 1px 2px #e6e6e6; border-top: 1px solid #e6e6e6">' +
                        '<table class="container-fluid">' +
                            '<td class="text-left ml-3"> <span class="ml-3"><?php echo $navLeft; ?></span> </td>' +
                            '<td class="text-right">' +
                                '<a class="btn mr-2" id="navSearch" href="q.php">' +
                                    '<img src="img/nav/search.svg">' +
                                    '<b style="display: block; font-size: 10px; color: #000000">Search</b>' +
                                '</a>' +
                            '</td>' +
                        '</table>' +
                    '</div>'); }
</script>