<script>
    $(document).ready(function() {
        sO();
        wP();
        setInterval(function() {
            sO();
        }, 200000);
        function sO() {
            $.post("onlinestatus.php?action=stayOnline", function(responce) { });
        }
        function wP(){
            $.post("onlinestatus.php?action=whichPage&thisPage="+window.location.pathname, function(responce) { });
        }
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
        ul { max-width: 550px; }
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
    #navMessage { position: relative; }
    .badge {
        position: absolute;
        font-weight: bold;
        top: 5px;
        right: 5px;
    }
</style>

<?php
$showMsgCount = '';
if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true) {
    $uu = $_SESSION["username"];
    $sqlMsgNav = "SELECT count(hasseen) FROM message WHERE touser='$uu' AND hasseen=0";
    $resultMsgNav = $link->query($sqlMsgNav);
    $rowMsgNav = mysqli_fetch_array($resultMsgNav);

    if($rowMsgNav["count(hasseen)"] == 0) { }
    else if($rowMsgNav["count(hasseen)"] > 9) { $showMsgCount = '<span class="badge badge-pill badge-danger">9+</span>'; }
    else { $showMsgCount = '<span class="badge badge-pill badge-danger">'.$rowMsgNav["count(hasseen)"].'</span>'; }
}
?>

<nav id="menu" class="navbar-light bg-light">

    <script>
        if(screen.width > 600){ document.write('<img src="img/welcome/logomin.png" style="width: 35px; position: absolute; top: 5px; left: 5px;">'); }
    </script>

    <div align="center">
        <ul class="nav nav-fill">
            <li class="nav-item">
                <a class="nav-link" id="navHome" href="/"><img class="forNav" src="img/nav/home.svg"> <b class="navWritten">Home</b></a>
            </li>
            <script>if(screen.width>600){document.write('<li class="nav-item"><a class="nav-link" id="navMessage" href="message.php"><img class="forNav" src="img/nav/message.svg"> <?php echo $showMsgCount; ?> <b class="navWritten">Chats</b></a></li>');}</script>
            <li class="nav-item">
                <a class="nav-link" id="navSearch" href="q.php"><img class="forNav" src="img/nav/search.svg"> <b class="navWritten">Search</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navRadar" href="radar.php"><img class="forNav" src="img/nav/radar.svg"> <b class="navWritten">Radar</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navProfile" href="my.php"><img class="forNav" src="img/nav/profile.svg"> <b class="navWritten">Profile</b></a>
            </li>
        </ul>
    </div>
</nav>

<script>
    if(screen.width < 600){
        document.write('<div class="sticky-top bg-light" style="box-shadow: 0 1px 2px #e6e6e6; border-top: 1px solid #e6e6e6">' +
                        '<table class="container-fluid">' +
                            '<td class="text-left ml-3"> <span class="ml-3"><?php echo $navLeft; ?></span> </td>' +
                            '<td class="text-right">' +
                                '<a class="nav-link" id="navMessage" href="message.php">' +
                                    '<img src="img/nav/message.svg">' +
                                    '<?php echo $showMsgCount; ?>'+
                                '</a>' + 
                            '</td>' +
                        '</table>' +
                    '</div>'); }
</script>