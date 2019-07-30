</head>
<style>
    .btn { border-radius: 50px; }
    @media only screen and (min-width: 601px) {
        #index_pen { width: 50vw; }
        #index_des { max-width: 500px; }
    }
    @media only screen and (max-width: 600px) {
        .container-fluid { margin-top: 30px; }
        #index_des { text-align: center; }
        #index_pen { width: 90vw; }
    }
</style>
<body>

   <div class="container-fluid">

        <h1><b>𝓣𝓱𝓲𝓻𝓭 𝓛𝓪𝔀</b></h1>
        <h5 class="text-secondary mb-5" id="index_des">
            Make private list of people you like and get match if they added you as well!
            Share expressions with next-gen messenging system!
        </h5>

        <div class="row">
            <div class="col" align="right">
                <div id="index_btn">
                    <div class="row">
                        <div class="col"><a class="btn btn-outline-primary btn-block" href="login.php"> <i class="material-icons-outlined">verified_user</i> <b>Log-in</b></a></div>
                        <div class="col"><a class="btn btn-outline-primary btn-block" href="register.php"> <i class="material-icons-outlined">person_add</i> <b>Regsiter</b></a></div>
                    </div><br/>
                </div>

                <form action="" onsubmit="return doit()">
                    <div class="input-group mb-3">
                        <input id="q" type="text" class="form-control" aria-label="Search anything" placeholder="Search people..." style="padding: 20px; border-top-left-radius: 50px; border-bottom-left-radius: 50px;">
                        <div class="input-group-append">
                            <button class="input-group-text" style="width: 50px; padding: 8px; border-top-right-radius: 50px; border-bottom-right-radius: 50px;"><i class="material-icons-outlined">search</i></button>
                        </div>
                    </div>
                </form>
                <div id="showSearchResult" align="left"></div><br/>
                <script>
                    function doit() {
                        var q = $("#q").val();
                        if(q != '') {
                            $("#showSearchResult").css("display", "block");
                            $.post("search.php?action=getuser&q=" + q, function(responce) {
                                $("#showSearchResult").html(responce);
                            });
                        } else {
                            $("#showSearchResult").css("display", "none");
                        }
                        return false;
                    }
                </script>

            </div>

            <div class="col">
                <img src="img/index_pen.jpg" id="index_pen">
            </div>
        </div>
        <br/><br/><br/><br/><br/>

        <footer class="bg-light fixed-bottom" align="center">
            <a class="btn btn-primary btn-block mb-3" href="know.php"> <i class="material-icons-outlined">info</i> <b>Know More</b></a>
            <h6><b>Ishan Mathur &copy; Production</b></h6>
        </footer>

   </div>