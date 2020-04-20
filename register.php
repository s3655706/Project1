<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="./css/bootstrap.css"/>
    <link rel="stylesheet" href="./css/bootstrap-theme.css"/>
</head>
<?php
require_once "common.php";
$email_error = null;
$password_error = null;
$email = null;
$username = null;
$age = null;
$gender = null;
$phone = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $age = ($_POST['age']);
    $gender = ($_POST['gender']);
    $phone = ($_POST['phone']);
    $username = ($_POST['username']);


    $db = getConnection();
    $sql = "SELECT * FROM users WHERE email='{$email}'";


    $stmt = oci_parse($db, $sql);
    oci_execute($stmt);

    if (oci_fetch_array($stmt)) {
        $email_error = 'register fail, email is already exist';
    } else {
        $sql = "insert into users(email,username,password,phone,age,gender) values('{$email}','{$username}','{$password}','{$phone}',{$age},'{$gender}')";
        $stmt = oci_parse($db, $sql);
        oci_execute($stmt);
        if ($stmt) {
            echo "<script>
                alert('register success');
                window.location.href = 'login.php';
                  </script>";
            exit;
        }

    }

}

?>
<body>
<div style="margin-bottom: 60px;margin-top: 50px;">
    <h2 class="text-center">Welcome to GoodJob</h2>
</div>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-4 col-md-offset-4">
            <h3 class="text-center"><strong>Register</strong></h3>
            <form action="register.php" method="post" onsubmit="return check()">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input value="<?= $email == null ? '' : $email ?>" name="email" type="email" required
                           class="form-control" id="email"
                           placeholder="please input your email">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input value="<?= $username == null ? '' : $username ?>" name="username" type="username" required
                           class="form-control" id="username"
                           placeholder="please input your username">
                </div>
               
                <div class="form-group">
                    <label for="age">Age</label>
                    <input value="<?= $age == null ? '' : $age ?>" name="age" type="text" class="form-control" id="age"
                           placeholder="age">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input value="<?= $phone == null ? '' : $phone ?>" required maxlength="10" name="phone" type="text"
                           class="form-control" id="phone"
                           placeholder="phone">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" class="form-control" id="gender">
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>

                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input maxlength="20" name="password" required type="password" class="form-control" id="password"
                           placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input maxlength="20" name="confirm_password" type="password" class="form-control"
                           id="confirm_password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Regiser</button>
                | <a href="login.php">Already have an account, log in.</a>
            </form>
        </div>

    </div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
    function check() {
        var username = $("#username").val();
        var password = $("#password").val();
        var cpassword = $("#confirm_password").val();
        var phone = $("#phone").val();

        var pusername = /[A-Za-z]\w{1,19}/
        if (pusername != '' && !pusername.test(username)) {
            alert("username should start with letter");
            return false;
        }
        var pwd1 = /[A-Za-z]{1,}/
        var pwd2 = /[0-9]{1,}/
        if (password != '' && (!pwd1.test(password) || !pwd2.test(password))) {
            alert("Password must be a combination of letters and numbers");
            return false;
        }
        if (cpassword != '' && (!pwd1.test(cpassword) || !pwd2.test(cpassword))) {
            alert("Confirm password must be a combination of letters and numbers");
            return false;
        }
        if (password != cpassword) {
            alert("The password entered twice is different");
            return false;
        }
        var phone1 = /04[0-9]{8}/
        if (phone != '' && !phone1.test(phone)) {
            alert("Phone must start with 04 and have 10 digits");
            return false;
        }
        return true;
    }
</script>
</html>