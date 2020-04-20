<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mypost</title>
    <link rel="stylesheet" href="./css/bootstrap.css"/>
    <link rel="stylesheet" href="./css/bootstrap-theme.css"/>
</head>
<body>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php
        require_once "header.php";
        require_once "common.php";
        $db = getConnection();

        ?>

    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="col-md-12">


            <div class="panel panel-default">
                <div class="panel-heading">My Post &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default" href="addpost.php">Publish Post</a></div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <th>Title</th>
                        <th>Publish Time</th>
                        <th>Work Domain</th>
                        <th>Post Type</th>
                        <th>Education Requirement</th>
                        <th>Operation</th>
                        </thead>
                        <?php


                        $sql = "SELECT * FROM posts WHERE user_email='{$_SESSION['email']}'";
                        $stmt = oci_parse($db, $sql);
                        oci_execute($stmt);
                        if ($stmt)
                            while (oci_fetch_array($stmt)) { ?>


                                <tr>
                                    <td><?= oci_result($stmt,"TITLE")  ?></td>
                                    <td><?= oci_result($stmt,"PUBLISH_TIME")   ?></td>
                                    <td><?= $areas[oci_result($stmt,"AREA_ID")] ?></td>
                                    <td><?= oci_result($stmt,"POST_TYPE") == 1 ? 'Apply' : 'Recruitment' ?></td>
                                    <td><?= $educations[oci_result($stmt,"EDUCATION_TYPE")] ?></td>
                                    <td>
                                        <a href="#">Delete</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="#">Edit</a>
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
