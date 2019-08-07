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

    <!--<canvas id="canvas" style="display: block"></canvas>
        <script>
            "use strict";

            function _instanceof(left, right) { if (right != null && typeof Symbol !== "undefined" && right[Symbol.hasInstance]) { return !!right[Symbol.hasInstance](left); } else { return left instanceof right; } }

            function _classCallCheck(instance, Constructor) { if (!_instanceof(instance, Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

            function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

            function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

            var canvas;
            var ctx;
            var w, h;
            var mouseX, mouseY;
            var stacks;

            var Stack =
            /*#__PURE__*/
            function () {
            function Stack(x, y) {
                _classCallCheck(this, Stack);

                this.x = x;
                this.y = y;
                this.size = Math.random() * 40 + 60;
            }

            _createClass(Stack, [{
                key: "draw",
                value: function draw(angle, sizeFactor) {
                var deltaX = Math.cos(angle) * sizeFactor * 0.015;
                var deltaY = Math.sin(angle) * sizeFactor * 0.015;

                for (var i = 0; i < 14; i++) {
                    drawSquare(this.x - i * deltaX, this.y - i * deltaY, this.size + i * 3);
                }
                }
            }]);

            return Stack;
            }();

            function setup() {
            canvas = document.querySelector("#canvas");
            ctx = canvas.getContext("2d");
            reset();
            window.addEventListener("resize", reset);
            canvas.addEventListener("mousemove", mousemove);
            mouseX = w * 0.75;
            mouseY = h * 0.75;
            }

            function reset() {
            w = canvas.width = window.innerWidth;
            h = canvas.height = window.innerHeight;
            setupStacks();
            }

            function draw() {
            requestAnimationFrame(draw);
            ctx.fillStyle = "white";
            ctx.fillRect(0, 0, w, h);
            drawStacks();
            }

            function setupStacks() {
            var nrOfStacks = w * h / 5000;
            stacks = [];

            for (var i = 0; i < nrOfStacks; i++) {
                var x = Math.random() * w;
                var y = Math.random() * h;
                var stack = new Stack(x, y);
                stacks.push(stack);
            }
            }

            function drawStacks() {
            stacks.forEach(function (stack) {
                var deltaY = mouseY - stack.y;
                var deltaX = mouseX - stack.x;
                var angle = Math.atan2(deltaY, deltaX);
                var distFromCenter = Math.sqrt(deltaX * deltaX + deltaY * deltaY);
                stack.draw(angle, distFromCenter);
            });
            }

            function drawSquare(x, y, size) {
            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(Math.PI / 3);
            ctx.strokeRect(-size / 2, -size / 2, size, size);
            ctx.fillRect(-size / 2 + 1, -size / 2 + 1, size - 2, size - 2);
            ctx.restore();
            }

            function mousemove(event) {
            mouseX = event.clientX;
            mouseY = event.clientY;
            }

            setup();
            draw();
        </script>-->

        <div class="row">
            <div class="col" align="center">

                <h1><b>𝓣𝓱𝓲𝓻𝓭 𝓛𝓪𝔀</b></h1>
                <script>
                    if(screen.width>600){ document.write('<h5 class="text-secondary mb-5" id="index_des"> Make private list of people you like and get match if they added you as well! Share expressions with next-gen messenging system! </h5>'); }
                    else { document.write('<br/><br/><br/>'); }
                </script>

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

                <div id="index_btn">
                    <a class="btn btn-outline-primary" href="login.php"> <i class="material-icons-outlined">verified_user</i> <b>Log-in</b></a> &nbsp;
                    <a class="btn btn-outline-primary" href="register.php"> <i class="material-icons-outlined">person_add</i> <b>Regsiter</b></a>
                </div><br/><br/>

            </div>

            <div class="col">
                <img src="img/index_pen.jpg" id="index_pen">
            </div>
        </div>
        <br/><br/><br/><br/><br/>

        <footer class="bg-light fixed-bottom" align="center">
            <a class="btn alert-primary mb-3" href="know.php" style="width: 80vw"> <i class="material-icons-outlined">info</i> <b>Know More</b></a>
            <h6><b>Ishan Mathur &copy; Production</b></h6>
        </footer>

   </div>