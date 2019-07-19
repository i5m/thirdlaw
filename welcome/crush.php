<style>
    .crushBtn {
        position: relative;
        border-radius: 15px;
        z-index: 999;
        margin: 10px;
        box-shadow: 0 2px 8px #e6e6e6;
        border: 1px solid #d6d8db;
        padding: 5px;
        min-width: 250px;
    }
    .crushImg {
        border-radius: 50px;
        border: 2px solid #d6d8db;
        width: 60px;
        height: 60px;
    }
    .activeImg {
        position: absolute;
        top: 50%;
        right: 7px;
        transform: translate(-50%, -50%);
    }
    @media only screen and (max-width: 600px) { .crushBtn { display: block; } }
</style>
<div>
    <img src="img/welcome/logominout.png" height="30px"> &nbsp;
    <b class="welcomeTopics">Your crushes</b> <br/> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <button type="button" class="btn btn-outline-primary" id="crushKnowBtn" data-toggle="modal" data-target="#knowmore">
        <i class="material-icons-outlined">info</i> <b> Know More</b>
    </button>
</div><br/>
<?php
$sqlCrush = "SELECT users.id, users.username, users.fullname, users.ploc, crushes.crush, crushes.user
            FROM users
            INNER JOIN crushes ON users.username=crushes.crush
            WHERE crushes.user='$u'
            ORDER BY added_at DESC
            LIMIT 6";
/*$sqlCrush = "SELECT id, username, fullname, ploc FROM users WHERE username IN (SELECT crush FROM crushes WHERE user='$u')";

            SELECT users.id, users.username, users.fullname, users.ploc, crushes.crush, crushes.user
            FROM users
            INNER JOIN crushes ON users.username=crushes.user
            WHERE crush IN (
            SELECT crush
            FROM crushes
            WHERE user='test0'    
            )*/
$resultCrush = $link->query($sqlCrush);
if ($resultCrush->num_rows > 0) {
    $waiting = 1;
    while ($rowCrush = $resultCrush->fetch_assoc()) {
        $sqlRevCrush = "SELECT crush FROM crushes WHERE user='" . $rowCrush["username"] . "' AND crush='$u'";
        $resultRevCrush = $link->query($sqlRevCrush);
        if ($resultRevCrush->num_rows > 0) {
            $waiting = 0;
            $addActiveCrushClass = 'alert-success';
            $showActiveCrushImg = '<img class="activeImg" src="../img/welcome/logomin.png" width="35px">';
        } else {
            $addActiveCrushClass = '';
            $showActiveCrushImg = '';
        }
        $crushUserName = (strlen($rowCrush["username"]) > 8) ? substr($rowCrush["username"],0,8).'...' : $rowCrush["username"];

            echo '<a class="btn crushBtn '.$addActiveCrushClass.'" class="media" href="profile.php?id=' . $rowCrush["id"] . '">
                    <div class="media">
                        <div class="crushImg align-self-center mr-3" style="background-image: url(' . $rowCrush["ploc"] . '); background-repeat: no-repeat; background-position: center; background-size: cover;"></div>
                        <div class="media-body text-dark my-auto" align="left">
                            <h5><b>'.$crushUserName.'</b></h5>
                        </div>
                    </div>
                    '.$showActiveCrushImg.'
                </a>';
    }
    if($waiting == 1){
        echo '<br><br><br>';
        echo '<div class="row" align="center">
                <div class="col my-auto" style="min-width: 250px;">
                    <h5>Hard Luck till now... But don\'t worry.<br>Some might be there feeling same wih you on thier list</h5>
                </div>
                <div class="col" style="min-width: 250px;">
                    <img src="../img/home/waiting.png" width="200px" height="auto">
                </div>
            </div><br/>';
    }
    if($waiting == 0){
        echo '<br><br><br>';
        echo '<div class="row" align="center">
                <div class="col my-auto" style="min-width: 250px;">
                    <h5><b style="color: green">Congratulations</b>, you have a match!!!<br/>
                    Click below to check out styles, tips & nearby places to go and meet or impress</h5>
                    <a class="btn alert-success" id="happyBtn" href="happy.php"><i class="material-icons-outlined">category</i> <b>I\'m feeling happy</b></a>
                </div>
                <div class="col" style="min-width: 250px;">
                    <img src="../img/home/herohappy.svg" width="250px" height="auto">
                </div>
            </div><br/>';
    }
    
} else {
    echo '<div align="center">
            <p>You haven\'t added anyone to your crush list. <br> Do this by clicking the button below or above.</p>
            <img src="../img/home/empty.png" width="200px" height="auto">
        </div><br/>';
}
?>
<div align="center">
    <a class="btn btn-primary" href="q.php"><i class="material-icons-outlined">favorite_border</i> <b>Add Crush</b></a>
    <a class="btn alert-primary" href="customuser.php"><i class="material-icons-outlined">hourglass_empty</i> Cutom Add</a><br/>
</div>
<script>
    $(document).ready(function(){
        $('#crushKnowBtn').click(function() {
            $("#knowhead").html('Crush');
            $("#knowbody").html('Here are all the people you have added in your crush list.<br/>If any of them has a crush on you as well... you\'ll get a match and <b>a lot other options</b>');
        });
    });
</script>