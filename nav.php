<script>
    $(document).ready(function() {
        sO();
        setInterval(function() {
            sO();
        }, 200000);
        function sO() {
            $.post("onlinestatus.php?action=stayOnline", function(responce) { });
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
        .activehai { border-bottom: 3px solid #007bff; }
    }
    @media only screen and (max-width: 599px) {
        #menu { border-top: 1px solid #d9d9d9; bottom: 0; box-shadow: 0 -1px 2px #e6e6e6; }
        .nav-link { padding-top: 3px; padding-bottom: 3px; }
        .navWritten { font-size: 3vw; display: block; margin-left: 1.5vw; }
        .forNavMat { font-size: 7.5vw; }
    }
    @media only screen and (max-width: 450px) {
        .forNavMat { width: 6vw; }
    }
    @media only screen and (max-width: 270px) {
        .forNavMat { width: 4vw; }
    }
    #navMessage { position: relative; }
    .badge {
        position: absolute;
        font-weight: bold;
        bottom: 0;
        right: 5px;
    }
    .activehai { color: #007bff; }
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
                <a class="nav-link" id="navHome" href="/"><i class="material-icons-outlined forNavMat">ballot</i><b class="navWritten">Home</b></a>
            </li>
            <script>if(screen.width>600){document.write('<li class="nav-item"><a class="nav-link" id="navMessage" href="message.php"><i class="material-icons-outlined forNavMat">sms</i><?php echo $showMsgCount; ?><b class="navWritten">Chats</b></a></li>');}</script>
            <li class="nav-item">
                <a class="nav-link" id="navSearch" href="q.php"><i class="material-icons-outlined forNavMat">search</i><b class="navWritten">Search</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navRadar" href="radar.php"><i class="material-icons-outlined forNavMat">explore</i><b class="navWritten">Radar</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navProfile" href="my.php"><i class="material-icons-outlined forNavMat">person</i><b class="navWritten">Profile</b></a>
            </li>
        </ul>
    </div>
</nav>

<script>
    if(screen.width < 600){
        document.write('<div class="sticky-top bg-light" style="box-shadow: 0 1px 2px #e6e6e6; border-top: 1px solid #e6e6e6; padding: 5px;">' +
                        '<table class="container-fluid">' +
                            '<td class="text-left ml-3"> <span class="ml-3"><?php echo $navLeft; ?></span> </td>' +
                            '<td class="text-right">' +
                                '<a class="nav-link" id="navMessage" href="message.php">' +
                                    '<i class="material-icons-outlined" style="font-size: 8vw; color: #007bff">sms</i>' +
                                    '<?php echo $showMsgCount; ?>'+
                                '</a>' + 
                            '</td>' +
                        '</table>' +
                    '</div>'); }
</script>