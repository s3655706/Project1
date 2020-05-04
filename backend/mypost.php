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
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['method']) && $_GET['method'] == 'delete') {
            $id = $_GET['id'];
            $sql = "delete from posts where id='{$id}'";
            $stmt = oci_parse($db, $sql);
            oci_execute($stmt);

            $sql = "delete from comments where post_id='{$id}'";
            $stmt1 = oci_parse($db, $sql);
            oci_execute($stmt1);

            if ($stmt) {
                echo "<script>
            alert('delete success');
            window.location.href = 'mypost.php';
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


            <div class="panel panel-default">
                <div class="panel-heading">My Post &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default"
                                                                              href="addpost.php">Publish Job</a></div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <th>Job Title</th>
                        <th>Publish Time</th>
                        <th>Job Field</th>
                        <th>Job Type</th>
                        <th>Education</th>
                        <th>Operation</th>
                        </thead>
                        <?php


                        $sql = "SELECT * FROM posts WHERE user_email='{$_SESSION['email']}'";
                        $stmt = oci_parse($db, $sql);
                        oci_execute($stmt);
                        if ($stmt)
                            while (oci_fetch_array($stmt)) { ?>


                                <tr>
                                    <td><?= oci_result($stmt, "TITLE") ?></td>
                                    <td><?= oci_result($stmt, "PUBLISH_TIME") ?></td>
                                    <td><?= $areas[oci_result($stmt, "AREA_ID")] ?></td>
                                    <td><?= oci_result($stmt, "POST_TYPE") == 1 ? 'Apply for a job' : 'Advertise job offers' ?></td>
                                    <td><?= $educations[oci_result($stmt, "EDUCATION_TYPE")] ?></td>
                                    <td>
                                        <a href="#" onclick="delete_post('<?= oci_result($stmt, "ID") ?>')">Delete</a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="editpost.php?id=<?= oci_result($stmt, "ID") ?>">Edit</a>
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
<script type="text/javascript">
    function delete_post(id) {
        if (confirm('are you sure to delete this?')) {
            window.location.href = 'mypost.php?method=delete&id=' + id;
        }
    }
</script>
</html>
