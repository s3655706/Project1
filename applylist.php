<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mypost</title>
    <link rel="stylesheet" href="./css/bootstrap.css"/>
    <link rel="stylesheet" href="./css/bootstrap-theme.css"/>
</head>
<body style="background-image: url('fonts/mypost.jpg');background-size: cover;background-position: center;background-attachment: fixed;">
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php
        require_once "header.php";
        require_once "common.php";
        $db = getConnection();
        $id = null;
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['id'])) {

            echo "URL error";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = $_GET['id'];

        }
        ?>

    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="col-md-12">


            <div class="panel panel-default">
                <div class="panel-heading">Apply List &nbsp;&nbsp;</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <th>Post Title</th>
                        <th>Apply User</th>
                        <th>Job Field</th>
                        <th>Education</th>
                        <th>Apply Time</th>
                        <th>Email</th>
                        </thead>
                        <?php


                        $sql = "SELECT TA.*,TB.title,TC.username,TC.education,TC.area_id FROM users_post TA join posts TB ON TA.post_id=TB.id
                                join users TC ON TA.user_email=TC.email
                                WHERE TA.post_id='{$id}'";
                        $stmt = oci_parse($db, $sql);
                        oci_execute($stmt);
                        if ($stmt)
                            while (oci_fetch_array($stmt)) { ?>


                                <tr>
                                    <td><?= oci_result($stmt, "TITLE") ?></td>
                                    <td><?= oci_result($stmt, "USERNAME") ?></td>
                                    <td><?= $areas[oci_result($stmt, "AREA_ID")] ?></td>
                                    <td><?= $educations[oci_result($stmt, "EDUCATION")] ?></td>
                                    <td>
                                        <?= oci_result($stmt, "APPLY_TIME") ?>
                                    </td>
                                    <td>
                                    <?= oci_result($stmt, "USER_EMAIL") ?>
                                    </td>

                                </tr>


                                <?php
                            }
                        ?>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>
