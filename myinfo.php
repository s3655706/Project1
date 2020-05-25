<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Info</title>
    <link rel="stylesheet" href="./css/bootstrap.css"/>
    <link rel="stylesheet" href="./css/bootstrap-theme.css"/>
</head>
<body style="background-image: url('fonts/myinfor.jpg');background-size: cover;background-position: center;background-attachment: fixed;">
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php
        require_once "header.php";
        require_once "common.php";

        $db = getConnection();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = ($_POST['email']);
            $password = ($_POST['password']);
            $age = ($_POST['age']);
            $gender = ($_POST['gender']);
            $phone = ($_POST['phone']);
            $username = ($_POST['username']);

            $type = $_POST['type'];
            $work = $_POST['work'];
            $eduction = $_POST['eduction'];
            $title = $_POST['title'];

            $sql = "UPDATE users SET
                            username='{$username}',
                            password='{$password}',
                            phone='{$phone}',
                            age={$age},
                            gender='{$gender}',
                            user_type={$type},
                            area_id={$work},
                            education={$eduction},
                            description='{$title}'  WHERE email='{$email}'";
            $stmt = oci_parse($db, $sql);
            oci_execute($stmt);
            if ($stmt) {
                $_SESSION['username'] = $username;
                $_SESSION['user_type'] = $type;
                $_SESSION['area_id'] = $work;
                $_SESSION['education'] = $eduction;
                $_SESSION['description'] = $title;
                echo "<script>
            alert('save success');
            window.location.href = 'myinfo.php';
        </script>";
                exit;
            }

        }
        ?>

    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="col-md-12">


            <div>
                <div class="panel-body">
                    <form class="form-horizontal" action="myinfo.php" method="post">

                        <?php

                        $db = getConnection();

                        $sql = "SELECT * FROM users WHERE email='{$_SESSION['email']}'";
                        $stmt = oci_parse($db, $sql);
                        oci_execute($stmt);

                        if (oci_fetch_array($stmt)) {
                            ?>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10"><input readonly value="<?= oci_result($stmt, "EMAIL") ?>"
                                                              name="email" type="email"
                                                              required
                                                              class="form-control" id="email"
                                                              placeholder="please input your email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10"><input value="<?= oci_result($stmt, "USERNAME") ?>"
                                                              name="username"
                                                              type="username" required
                                                              class="form-control" id="username"
                                                              placeholder="please input your username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input maxlength="20" value="<?= oci_result($stmt, "PASSWORD") ?>" name="password"
                                           required
                                           type="password" class="form-control" id="password"
                                           placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="age" class="col-sm-2 control-label">Age</label>
                                <div class="col-sm-10"><input value="<?= oci_result($stmt, "AGE") ?>" name="age"
                                                              type="text"
                                                              class="form-control" id="age"
                                                              placeholder="age">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-10"><input value="<?= oci_result($stmt, "PHONE") ?>" required
                                                              maxlength="10"
                                                              name="phone" type="text"
                                                              class="form-control" id="phone"
                                                              placeholder="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="col-sm-2 control-label">Gender</label>
                                <div class="col-sm-10"><select name="gender" class="form-control" id="gender">
                                        <option <?= oci_result($stmt, "GENDER") == 'Female' ? 'selected' : '' ?>
                                                value="Female">Female
                                        </option>
                                        <option <?= oci_result($stmt, "GENDER") == 'Male' ? 'selected' : '' ?>
                                                value="Male">Male
                                        </option>

                                    </select>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">Type of user</label>
                            <div class="col-sm-10 ">
                                <select name="type" class="form-control" id="type">
                                    <option <?= !isset($_SESSION['user_type']) ? 'selected' : '' ?> value="0">None</option>
                                    <option <?= isset($_SESSION['user_type']) && $_SESSION['user_type'] == '1' ? 'selected' : '' ?>
                                            value="1">Employer
                                    </option>
                                    <option <?= isset($_SESSION['user_type']) && $_SESSION['user_type'] == '2' ? 'selected' : '' ?>
                                            value="2">Employee
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="work" class="col-sm-2 control-label">Job Field</label>
                            <div class="col-sm-10 ">
                                <select name="work" class="form-control" id="work">
                                    <option <?= !isset($_SESSION['area_id']) != null ? 'selected' : '' ?> value="0">None
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '1' ? 'selected' : '' ?>
                                            value="1">Computer Science
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '2' ? 'selected' : '' ?>
                                            value="2">Construction Engineering
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '3' ? 'selected' : '' ?>
                                            value="3">Art
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '4' ? 'selected' : '' ?>
                                            value="4">Financial
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '5' ? 'selected' : '' ?>
                                            value="5">Education
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '6' ? 'selected' : '' ?>
                                            value="6">Transport Engineering
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '7' ? 'selected' : '' ?>
                                            value="7">Medicine
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '8' ? 'selected' : '' ?>
                                            value="8">Administration
                                    </option>
                                    <option <?= isset($_SESSION['area_id']) != null && $_SESSION['area_id'] == '9' ? 'selected' : '' ?>
                                            value="9">Others
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="eduction" class="col-sm-2 control-label">Education</label>
                            <div class="col-sm-10 ">
                                <select name="eduction" class="form-control" id="eduction">
                                    <option <?= !isset($_SESSION['education']) ? 'selected' : '' ?>
                                            value="0">None
                                    </option>
                                    <option <?= isset($_SESSION['education']) != null && $_SESSION['education'] == '1' ? 'selected' : '' ?>
                                            value="1">High school and Below
                                    </option>
                                    <option <?= isset($_SESSION['education']) != null && $_SESSION['education'] == '2' ? 'selected' : '' ?>
                                            value="2">Junior College
                                    </option>
                                    <option <?= isset($_SESSION['education']) != null && $_SESSION['education'] == '3' ? 'selected' : '' ?>
                                            value="3">Undergraduate
                                    </option>
                                    <option <?= isset($_SESSION['education']) != null && $_SESSION['education'] == '4' ? 'selected' : '' ?>
                                            value="4">Postgraduate and Above
                                    </option>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Background</label>
                            <div class="col-sm-10">
                                <input value="<?= $_SESSION['description'] ?>" name="title" type="text"
                                       class="form-control" id="title" placeholder="title">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>