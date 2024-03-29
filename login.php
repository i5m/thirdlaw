<?php require_once('config.php');
if (isset($_COOKIE["loggedin"])) {
    header("location: /");
    exit;
}

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {

                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {

                            setcookie("loggedin", true, time() + 86400*365);
                            setcookie("id", $id, time() + 86400*365);
                            setcookie("username", $username, time() + 86400*365);
                        
                            header("location: /");
                        } else {
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>
<?php require_once('header.php'); ?>
<style>
    .container {
        max-width: 400px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
</style>
</head>

<body>
    <div class="container" align="center">
        <h2> <i class="material-icons-outlined">local_cafe</i> <b>Log In</b></h2><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">account_circle</i></span>
                    </div>
                    <input type="text" name="username" value="<?php echo $username; ?>" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <p style="color: red"><?php echo $username_err; ?></p>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="material-icons-outlined">lock</i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                </div>
                <p style="color: red"><?php echo $password_err; ?></p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary"><b>Login</b></button>
            </div><br>
            <p style="box-shadow: 0 2px 4px #a6a6a6; border-radius: 50px;">Don't have an account? <br> <a href="register.php"><b>Sign up now</b></a>.</p>
        </form>
    </div>

    <?php require_once('footer.php'); ?>