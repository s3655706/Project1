<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="./css/bootstrap.css"/>
    <link rel="stylesheet" href="./css/bootstrap-theme.css"/>
</head>
<?php
require_once "common.php";
$email_error = null;
$password_error = null;
$email = null;
$password = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = ($_POST['email']);
    $password = ($_POST['password']);

    
    }


    $db = getConnection();
    $sql = "SELECT username,password,email,user_type, area_id, education, description  FROM users WHERE email='{$email}'";
    $stmt = oci_parse($db, $sql);
    oci_execute($stmt);

    if (oci_fetch_array($stmt)) {

        if (($password) == oci_result($stmt, "PASSWORD")) {
            $_SESSION['email'] = oci_result($stmt, "EMAIL");
            $_SESSION['username'] = oci_result($stmt, "USERNAME");
            $_SESSION['user_type'] = oci_result($stmt, "USER_TYPE");
            $_SESSION['area_id'] = oci_result($stmt, "AREA_ID");
            $_SESSION['education'] = oci_result($stmt, "EDUCATION");
            $_SESSION['description'] = oci_result($stmt, "DESCRIPTION");
            echo "<script>
                alert('login success');
                window.location.href = 'main.php';
            </script>";
            exit;

        } else {
            $password_error = 'login fail, password is not right';
        }
    } else {
        $email_error = 'login fail, email does not exist';
    }


}

?>
<body>
<div style="margin-bottom: 150px;margin-top: 50px;">
    <h2 class="text-center">Welcome to GoodJob</h2>
    <h3 class="text-center">Looking for a job?</h3>
    <h4 class="text-center">We understand that for you, it’s never just a job: it’s your future. <h4>
</div>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-4 col-md-offset-4">
            <h3 class="text-center"><strong>Login</strong></h3>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input value="<?= $email == null ? '' : $email ?>" name="email" required type="email"
                           class="form-control" id="email"
                           placeholder="please input your email">
                    <?php
                    if ($email_error != null) {
                        echo "  <span style=\"color: red\">{$email_error}</span>";
                    }
                    ?>

                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input value="<?= $password == null ? '' : $password ?>" name="password" required type="password"
                           class="form-control" id="exampleInputPassword1"
                           placeholder="Password">
                    <?php
                    if ($password_error != null) {
                        echo "  <span style=\"color: red\">{$password_error}</span>";
                    }
                    ?>
                </div>

                <button type="submit" class="btn btn-default">login</button>
                | <a href="register.php">No account yet? sign up now!</a>
            </form>
        </div>

    </div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>
