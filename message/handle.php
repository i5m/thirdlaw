<?php
if (!isset($_COOKIE["loggedin"])) { header("location: ../login.php"); exit; }
else { $u = $_COOKIE["username"]; }
require_once("../config.php");
$fromUser = $u;
$toUser = $_REQUEST["touser"];
switch($_REQUEST['action']) {
    case "sendMessage":
        $theMessage = $_REQUEST["theMessage"];
        if($theMessage != "") {
            $howreact = $_REQUEST["howreact"];
            $sqlAddMsg = "INSERT INTO message (fromuser, messagebody, touser, howreact) VALUES (?, ?, ?, ?)";

            if ($stmtAddMsg = mysqli_prepare($link, $sqlAddMsg)) {
                mysqli_stmt_bind_param($stmtAddMsg, "ssss", $param_fromuser, $param_messagebody, $param_touser, $param_howreact);

                $param_fromuser = $fromUser;
                $param_messagebody = $theMessage;
                $param_touser = $toUser;
                $param_howreact = $howreact;

                $didIt = mysqli_stmt_execute($stmtAddMsg);

                if ($didIt) { echo "1"; exit; }
                else { echo "Error: " . $sqlAddMsg . "<br>" . $link->error; }
            }
        }

    break;

    case "getMessage":
        $sqlMsgDisp = "SELECT * FROM message WHERE (fromuser='$u' OR fromuser='".$toUser."') AND (touser='".$toUser."' OR touser='$u') ORDER BY sent_at ASC LIMIT 1000";
        $resultMsgDisp = $link->query($sqlMsgDisp);
        while($rowMsgDisp = $resultMsgDisp->fetch_assoc()) {
            if($rowMsgDisp["howreact"] == "send") { $showEmoji = ''; $colorMsg = 'dark'; }
            else if($rowMsgDisp["howreact"] == "like") { $colorMsg = 'primary'; }
            else if($rowMsgDisp["howreact"] == "love" || $rowMsgDisp["howreact"] == "angry") {  $colorMsg = 'danger'; }
            else if($rowMsgDisp["howreact"] == "haha") {  $colorMsg = 'success'; }
            else if($rowMsgDisp["howreact"] == "wow" || $rowMsgDisp["howreact"] == "sad") { $colorMsg = 'warning'; }
            if($rowMsgDisp["fromuser"] == $u) {
                echo '<div style="text-align: right; position: relative;">
                        <div class="btn alert-light text-'.$colorMsg.' border-'.$colorMsg.' myMsg">'
                            .$rowMsgDisp["messagebody"].'
                        </div><br/>
                    </div>';
            }
            else {
                echo '<div style="text-align: left; position: relative;">
                        <div class="btn alert-light text-'.$colorMsg.' border-'.$colorMsg.' thierMsg">'
                            .$rowMsgDisp["messagebody"].'
                        </div>
                    <br></div>';
                    $sqlHasSeen = "UPDATE message SET hasseen=1, seen_at='".date("Y/m/d h:i:sa")."' WHERE id=".$rowMsgDisp["id"];
                    if ($link->query($sqlHasSeen) === TRUE) { echo '<div style="padding-right: 10px; color: #007bff;"><b>Seen</b></div>'; }
                    else { echo "Error updating record: " . $link->error; }
            }
        }

    break;

    case "lastBg":
        $sqlLastBg = "SELECT howreact FROM message WHERE (fromuser='$u' OR fromuser='".$toUser."') AND (touser='".$toUser."' OR touser='$u') ORDER BY sent_at DESC LIMIT 1";
        $resultLastBg = $link->query($sqlLastBg);
        $rowLastBg = mysqli_fetch_array($resultLastBg);
        if($rowLastBg["howreact"] == "send") { echo "#d6d8db"; }
        else if($rowLastBg["howreact"] == "like") { echo "#b8daff"; }
        else if($rowLastBg["howreact"] == "haha") { echo "#c3e6cb"; }
        else if($rowLastBg["howreact"] == "love" || $rowLastBg["howreact"] == "angry") { echo "#f5c6cb"; }
        else if($rowLastBg["howreact"] == "wow" || $rowLastBg["howreact"] == "sad") { echo "#ffeeba"; }

    break;

    case "getMood":
        $theMood = $_REQUEST["theMood"];
        $sqlMood = "SELECT messagebody, sent_at, touser, fromuser FROM message WHERE howreact = '$theMood' AND (fromuser='$u' OR fromuser='".$toUser."') AND (touser='".$toUser."' OR touser='$u') ORDER BY sent_at DESC LIMIT 1000";
        $resultMood = $link->query($sqlMood);
        if($resultMood->num_rows > 0) {
            while($rowMood = $resultMood->fetch_assoc()) {
                if($rowMood["fromuser"] == $u) { $kon = $u; }
                else { $kon = $toUser; }
                echo '<div>
                        <b>'.$kon.'</b><br/>
                        <div class="btn alert-dark myMsg">'
                            .$rowMood["messagebody"].'
                            <div class="sentat" style="font-size: 10px; color: gray;">'.substr($rowMood["sent_at"],11,5).'</div>
                        </div>
                    </div><br/>';
            }
        } else {
            echo "<br/><b align='center'>No Message Shared with that mood!</b>";
        }

    break;
}
?>
