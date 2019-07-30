<?php
require_once('config.php');
if (isset($_COOKIE["loggedin"])) { $u = $_COOKIE["username"]; }
else { $u = ''; }

if($_REQUEST["action"] == "getuser") {
    $q = $_REQUEST["q"];
    if(strlen($q) > 0) {
        if ((strlen($q) < 3) || (strlen($q) > 45)) {
            echo "<br><p align='center'><i class='material-icons-outlined'>warning</i> Min 3 & Max 45 Characters <i class='material-icons-outlined'>warning</i></p><div id='nosugdiv'></div>";
            echo "<script> if(window.location.pathname != '/'){ document.getElementById('nosugdiv').innerHTML = \"<img src='img/searchTools/bg.png' style='max-width: 400px; width: 90%; height: auto; position: fixed; bottom: 0; left: 50%; transform: translate(-50%, -50%);'>\"; } </script>";
        } 
        else {
            $sqlsearchExist = $link->prepare("SELECT username, whosearch, searchfreq FROM searches WHERE username='" . $u . "' AND whosearch=?");
            $sqlsearchExist->bind_param('s', $q);
            $sqlsearchExist->execute();
            $resultsearchExist = $sqlsearchExist->get_result();
            $rowsearchExist = mysqli_fetch_array($resultsearchExist);
            if ($resultsearchExist->num_rows > 0) {
                $incr = $rowsearchExist["searchfreq"];
                $incr = $incr + 1;
                $sqlsearch = "UPDATE searches SET searchfreq=$incr WHERE username='$u' AND whosearch='$q'";
                if ($link->query($sqlsearch) != TRUE) {
                    echo "Error: " . $sqlsearch . "<br>" . $link->error;
                }
            } else {
                $sqlsearch = "INSERT INTO searches (username, whosearch) VALUES (?, ?)";
                if ($stmtsearch = mysqli_prepare($link, $sqlsearch)) {
                    mysqli_stmt_bind_param($stmtsearch, "ss", $param_username, $param_whosearch);
                    $param_username = $u;
                    $param_whosearch = $q;
                    if (mysqli_stmt_execute($stmtsearch)) { }
                    else { echo "Error: " . $sqlsearch . "<br>" . $link->error; }
                }
            }

            $sql = $link->prepare("SELECT * FROM users WHERE (fullname LIKE ? OR username LIKE ? OR phone LIKE ? OR city LIKE ?) AND NOT username='$u'");
            $qTwo = "%".$q."%";
            $sql->bind_param('ssss', $qTwo, $qTwo, $qTwo, $qTwo);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<a class="alert" style="margin: 5px; padding: 5px;" href="profile.php?id='.$row["id"].'">
                            <div class="media">
                                <div class="mr-3" style="border-radius: 50px; border: 1px solid gray; width: 45px; height: 45px; background: url('.$row["ploc"].'); background-size: cover;" id="profilepic"></div>
                                <div class="media-body">
                                    <h6><b style="color: black">'.$row["fullname"].'</b><span style="color: gray; display: block;">@'.$row["username"].'</span></h6>
                                </div>
                            </div>
                        </a>';
                }
            } else {
                echo "noone";
            }
        }
    }
}
?>