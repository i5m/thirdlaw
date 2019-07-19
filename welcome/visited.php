<style>
    .visitSugBtn {
        position: relative;
        border-radius: 10px;
        margin: 3px;
        border: 1px solid #d9d9d9;
        min-height: 150px;
        width: 110px;
    }
    #visitedProfile, #suggestion { min-width: 250px; }
</style>
<div align="left">
    <img src="img/welcome/visitedProfile.png" height="30px">
    &nbsp; <b class="welcomeTopics">Visited Profile</b>
</div><br/>
<?php
$sqlVisited = "SELECT id, fullname, ploc FROM users WHERE username IN (SELECT whoprofile FROM profiles WHERE username='" . $u . "' ORDER BY stalked_at DESC) LIMIT 4";
$resultVisited = $link->query($sqlVisited);
if ($resultVisited->num_rows > 0) {
    while ($rowVisited = $resultVisited->fetch_assoc()) {
        echo '<a class="btn visitSugBtn" href="profile.php?id=' . $rowVisited["id"] . '">
                <div style="background: url(' . $rowVisited["ploc"] . '); background-size: contain; background-repeat: no-repeat; background-position: center; width: 84px; height: 84px; border-radius: 50%; border: 1px solid gray; margin-bottom: 10px;"></div>
                <h6><b>' . $rowVisited["fullname"] . '</b></h6>
            </a>';
    }
}
?>