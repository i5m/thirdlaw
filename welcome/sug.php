<style>
    #suggestion { margin-bottom: 25px; }
</style>
<div align="left">
    <img src="img/welcome/suggestion.png" height="30px">
    &nbsp; <b class="welcomeTopics">Suggestions...</b>
</div><br/>
<?php
$matchSur = $matchBday = $matchCity = $matchCollege = "";
$userSurName = $userBday = "plzdontworknayaar";
if(str_word_count($rowUser["fullname"]) > 1) {
    $userSurName = explode(" ", $rowUser["fullname"]);
    $userSurName = array_pop($userSurName);
    $matchSur = "fullname LIKE '%" . $userSurName . "%' ";
}
if(strlen($rowUser["bday"]) > 1) {
    $userBday = substr($rowUser["bday"], 0, 6);
    $matchBday = "OR bday LIKE '%" . $userBday . "%' ";
}
if(srtlen($rowUser["city"]) > 1) {
    $matchCity = "OR city = '" . $rowUser["city"] . "' ";
}
if(srtlen($rowUser["college"]) > 1) {
    $matchCollege = "OR college = '" . $rowUser["college"] . "' ";
}

$sqlSug = "SELECT id, fullname, ploc, city, bday, college FROM users WHERE
        (".$matchSur.$matchBday.$matchCity.$matchCollege.")
        AND NOT username='$u'
        ORDER BY created_at DESC
        LIMIT 6";

$resultSug = $link->query($sqlSug);
if ($resultSug->num_rows > 0) {
    while ($rowSug = $resultSug->fetch_assoc()) {
            echo '<a class="btn visitSugBtn" href="profile.php?id=' . $rowSug["id"] . '">
                    <div style="background: url(' . $rowSug["ploc"] . '); background-size: contain; background-repeat: no-repeat; background-position: center; width: 84px; height: 84px; border-radius: 50%; border: 1px solid gray; margin-bottom: 10px;"></div>
                    <h6><b>' . $rowSug["fullname"] . '</b>';

            if(strpos($rowSug["fullname"], $userSurName)) {
                echo '<span style="color: #ff66b3; display: block; font-size: 12px; margin-top: 3px;">Based on Surname</span>';
            }
            else if(strpos($rowSug["bday"], $userBday)) {
                echo '<span style="color: #ff66b3; display: block; font-size: 12px; margin-top: 3px;">Same B\'day Month</span>';
            }
            else if($rowSug["city"] == $rowUser["city"]) {
                echo '<span style="color: #ff66b3; display: block; font-size: 12px; margin-top: 3px;">Same City</span>';
            }
            else if($rowSug["college"] == $rowUser["college"]) {
                echo '<span style="color: #ff66b3; display: block; font-size: 12px; margin-top: 3px;">Same College</span>';
            }

            echo '</h6></a>';
    }
} else {
    echo 'No Suggestions';
}
?>
