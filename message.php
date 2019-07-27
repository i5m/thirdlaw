<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { header("location: login.php"); exit; }
else { $u = $_SESSION["username"]; }
require_once('header.php');

/*$sqlTo = "SELECT message.messagebody, users.id, users.fullname, users.ploc
        FROM users
        INNER JOIN message ON message.fromuser=users.username
        WHERE touser IN
        (SELECT touser FROM message WHERE touser='test0'
        ORDER BY sent_at DESC
        LIMIT 1)";

SELECT message.id, message.messagebody, message.fromuser, users.id, users.username, users.fullname, users.ploc
        FROM users
        INNER JOIN message ON message.fromuser=users.username WHERE touser='$u' ORDER BY sent_at DESC";

SELECT message.id, message.messagebody, users.id, users.username, users.fullname, users.ploc
FROM users
INNER JOIN message ON message.fromuser=users.username
WHERE touser='test2'
GROUP BY users.username
ORDER BY sent_at ASC

SELECT message.messagebody, users.id, users.fullname, users.ploc
FROM users
INNER JOIN message ON message.fromuser=users.username
WHERE
(SELECT touser FROM message WHERE touser='test2'
ORDER BY sent_at DESC
LIMIT 1)

SELECT messagebody FROM message WHERE touser IN (SELECT DISTINCT touser FROM message WHERE fromuser='test0') ORDER BY sent_at DESC;

SELECT message.touser, message.messagebody, users.id, users.fullname, users.ploc
FROM users
INNER JOIN message ON message.fromuser=users.username
WHERE touser='test0' AND fromuser =
(SELECT fromuser FROM message WHERE touser='test0'
ORDER BY sent_at DESC);

SELECT * FROM 
	(
        SELECT users.id, users.fullname, users.ploc, message.messagebody,
        ROW_NUMBER() OVER (PARTITION BY message.fromname ORDER BY message.sent_at DESC) AS RowNumber
        FROM users
        INNER JOIN message ON users.username = message.touser
        WHERE NOT users.username = 'rachel' AND 
        (message.fromuser = 'rachel' OR message.touser = 'rachel')
    ) as a
    WHERE a.RowNumber = 1

$sqlTo "SELECT users.id, users.fullname, users.ploc, message.messagebody
        FROM users
        INNER JOIN message ON users.username = message.touser
        WHERE NOT users.username = '$u' AND (message.fromuser = '$u' OR message.touser = '$u')";

$sqlTo = "SELECT users.id, users.fullname, users.ploc, message.fromuser
        FROM message
        INNER JOIN users ON users.username=message.fromuser
        WHERE (fromuser='$u' OR touser='$u') AND NOT users.username='$u'";
                SELECT id, username FROM users WHERE username IN (SELECT fromuser FROM message WHERE fromuser='ishan1' OR touser='ishan1') AND NOT username='ishan1'
        $resultTo = $link->query($sqlTo);

SELECT SQL_CALC_FOUND_ROWS
    u.id_user AS id,
    i.id_user_from,
    i.id_user_to,
    u.name AS name,
    UNIX_TIMESTAMP(i.date_msg) AS date_msg,
    i.message AS msg

    FROM inbox AS i
    INNER JOIN user AS u ON u.id_user = IF(i.id_user_from = 1 ***ME***, i.id_user_to, i.id_user_from)

    WHERE id_msg IN
    (SELECT MAX(id_msg) AS id FROM
    (
        SELECT id_msg, id_user_from AS id_with
        FROM inbox
        WHERE id_user_to = 1

        UNION ALL

        SELECT id_msg, id_user_to AS id_with
        FROM inbox
        WHERE id_user_from = 1) AS t

        GROUP BY id_with
    )
    ORDER BY i.id_msg DESC
        */

        $sqlTo = "SELECT DISTINCT users.id, users.fullname, users.username, users.ploc
                FROM users
                INNER JOIN message ON ((users.username = message.fromuser) OR (users.username = message.touser))
                WHERE NOT users.username = '$u' AND  (message.fromuser = '$u' OR message.touser = '$u')
                ORDER BY id ASC";
        $resultTo = $link->query($sqlTo);
        $navLeft = '<img src="img/welcome/continueMessage.png" height="28px"> &nbsp; <b style="font-size: 30px; vertical-align: middle;">Chats</b>';
?>
<style>
    @media only screen and (min-width: 600px) { .container { margin-top: 50px; } }
</style>
</head>
<body>
    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navMessage").addClass("activehai");
        });
    </script>

    <div id="forpcimg"></div>
    <script>
        if(screen.width >= 767){
             document.getElementById("forpcimg").innerHTML =
             '<img src="img/message/bg.png" style="position: fixed; right: 50px; bottom: 50px; max-width: 300px; width: 40vw; max-height: 260px;">';       
        }
    </script>

    <div class="container"><br>
        <div style="max-width: 450px;">
            <?php
            if ($resultTo->num_rows > 0) {
                while($rowTo = $resultTo->fetch_assoc()) {
                    $sqlLastMsg = "SELECT messagebody FROM message WHERE (fromuser='$u' OR fromuser='".$rowTo["username"]."') AND (touser='".$rowTo["username"]."' OR touser='$u') ORDER BY sent_at DESC LIMIT 1";
                    $resultLastMsg = $link->query($sqlLastMsg);
                    $rowLastMsg = mysqli_fetch_array($resultLastMsg);
                    $messagebody = (strlen($rowLastMsg["messagebody"]) < 30) ? $rowLastMsg["messagebody"] : substr($rowLastMsg["messagebody"], 0, 27)."...";
                    echo '<div class="media mb-3">
                            <img src="'.$rowTo["ploc"].'" class="align-self-center mr-3" alt="" width="40px">
                            <div class="media-body">
                                <a class="text-dark" href="message/index.php?id='.$rowTo["id"].'">
                                    <b>'.$rowTo["fullname"].'</b>
                                    <span style="display: block;">'.$messagebody.'</span>
                                </a>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>';
                }
            } else {
                echo "0 results";
            }
            $link->close();
            ?>
        </div>
    </div>

    <!--<video width="320" height="240" controls>
        <source src="movie.mp4" type="video/mp4">
        <source src="movie.ogg" type="video/ogg">
        Your browser does not support the video tag.
    </video>

    <script>
        const video = document.querySelector('video');
        const constraints = { audio: false, video: true };

        navigator.mediaDevices.getUserMedia(constraints)
        .then(function(stream) {
            video.srcObject = stream;
            video.play();
        }).catch(function(err) {
            //handle error
        });
    </script>-->

    <?php require_once('footer.php'); ?>