<div>
    <img src="img/welcome/radar.png" height="30px">
    &nbsp; <b class="welcomeTopics">Radar</b>
</div><br/>
<div align="center" style="min-width: 280px;">
    <h5>
        Know who's that good neighbour or his/her friend that seems to be intrested in you.<br />
        Help's you explore people near you.<br />
        Enabling you to find out users near your location for any cause relating to this site!
    </h5><br />
    <a class="btn btn-primary" href="../radar.php" id="radarFindBtn"><i class="material-icons-outlined">whatshot</i> <b> Search near me...</b></a>
    <button type="button" class="btn btn-outline-primary" id="radarKnowBtn" data-toggle="modal" data-target="#knowmore">
        <i class="material-icons-outlined">info</i> <b> Know More</b>
    </button><br /><br />
</div>
<script>
    $(document).ready(function(){
        $('#radarKnowBtn').click(function() {
            $("#knowhead").html('Radar');
            $("#knowbody").html(
                '<table class="table" style="color: gray">'+
                    '<tbody>'+
                        '<tr>'+
                            '<td><i class="material-icons-outlined">help_outline</i></td>'+
                            '<td><b>Based on your IP Address, the algorithm finds out location of you and people nearby.</b></td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><i class="material-icons-outlined">swap_vertical_circle</i></td>'+
                            '<td>'+
                                '<b>Users are sorted on the basis of thier last active session.</b><br/>'+
                            '</td>'+
                        '</tr>'+
                    '</tbody>'+
                '</table>'
            );
        });
    });
</script>