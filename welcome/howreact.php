<style>
    .howBtn { border-radius: 50px; margin: 5px; }
    #howBarDiv .howBarTab { display: inline-block; margin: 5px; }
    #howBarDiv .howBarBar { width: 30px; }
</style>
<div>
    <b class="welcomeTopics">
        <i class="material-icons-outlined">thumbs_up_down</i> &nbsp; Reactions
    </b> <br/> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <button type="button" class="btn btn-outline-primary" id="reactKnowBtn" data-toggle="modal" data-target="#knowmore">
        <i class="material-icons-outlined">info</i> <b> What's this?</b>
    </button>
</div><br/>
<div align="center">
    <?php
    $sqlReact = "SELECT howreact, Count(*)
                FROM message
                WHERE (fromuser='$u' OR touser='$u') AND NOT howreact='send'
                GROUP BY howreact";
    $resultReact = $link->query($sqlReact);

    $totalNum = 0;
    $howTotal = array();
    $howReact = array();
    while($rowReact = $resultReact->fetch_assoc()) {
        $totalNum += $rowReact["Count(*)"];
        array_push($howTotal, $rowReact["Count(*)"]);
        array_push($howReact, $rowReact["howreact"]);
    }

    echo '<div id="howBtnDiv">';
    for($i = 0; $i < sizeof($howReact); $i++){
        if($howReact[$i] == 'like') { $btnTxt = '👍🏻 Liked'; }
        else if($howReact[$i] == 'haha') { $btnTxt = '😂 Funny'; }
        else if($howReact[$i] == 'angry') { $btnTxt = '😡 Anger'; }
        else if($howReact[$i] == 'love') { $btnTxt = '😍 Love'; }
        else if($howReact[$i] == 'sad') { $btnTxt = '😭 Sad'; }
        else if($howReact[$i] == 'wow') { $btnTxt = '😲 Wooh!'; }
        echo '<button type="button" class="btn alert-dark howBtn" id="'.$howReact[$i].'"> <b>'.$btnTxt.'</b></button>';
    }
    echo '</div></br/>';

    echo '<script>';
    for($k = 0; $k < sizeof($howReact); $k++){
        echo 'var how'.$howReact[$k].'= '.$howTotal[$k].';';
    }
    echo '</script>';
    ?>

    <div id="reactSingleTab" style="display: none; position: relative;">
        <div class="media">
            <img id="howImg" src="" class="mr-5" width="60px">
            <div align="left" class="media-body">
                <h1 class="mt-0"><b id="howTotal"></b></h1>
                <h6>Messages have been exchanged by you</h6>
            </div>
        </div><br/>
        <button type="button" class="btn btn-dark btn-block" onclick="document.getElementById('reactSingleTab').style.display = 'none'"><i class="material-icons-outlined">close</i> Close</button>
    </div><br/>

    <div id="reactTab">
        <?php
        echo '<div id="howBarDiv">';
        for($j = 0; $j < sizeof($howTotal); $j++){

            if($howReact[$j] == "like") { $barColor = "primary"; }
            else if($howReact[$j] == "haha") { $barColor = "success"; }
            else if($howReact[$j] == "angry" || $howReact[$j] == "love") { $barColor = "danger"; }
            else if($howReact[$j] == "sad" || $howReact[$j] == "wow") { $barColor = "warning"; }

            $barHeight = $howTotal[$j] / max($howTotal) * 150;

            echo '<div class="howBarTab">
                    <div class="btn-'.$barColor.' howBarBar" style="height: '.$barHeight.'px;"></div>
                    <b>'.$howReact[$j].'</b>
                </div>';
        }
        echo '</div>';
        ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".howBtn").click(function(){
            $("#reactSingleTab").show();
            $("#howImg").attr("src", "img/message/"+this.id+".png");
            $("#howTotal").html( window["how"+this.id] + " " +this.id);
        });
        $('#reactKnowBtn').click(function() {
            $("#knowhead").html('Reactions');
            $("#knowbody").html('This graph shows the total amount of message <b>exchanged</b> (sent & recieved) by you and how was the reaction attached to each message in whole bar form');
        });
    });
</script>