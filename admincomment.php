<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mypost</title>
    <link rel="stylesheet" href="./css/bootstrap.css"/>
    <link rel="stylesheet" href="./css/bootstrap-theme.css"/>
</head>
<body style="background-image: url('fonts/admincomm.jpeg');background-size: cover;background-position: center;background-attachment: fixed;">
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <nav class="navbar navbar-default">
            <div class="container ">

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="adminpost.php"><strong style="color: black">GoodJob</strong> </a>
                    </div>

                    <ul class="nav navbar-nav">
                        <li><a href="adminpost.php">Post List</a></li>
                        <li><a href="admincomment.php">Comment List</a></li>

                    </ul>

                    <ul class="nav navbar-nav">
                        <li><a>Welcome to GoodJob,&nbsp;<?= $_SESSION['email'] ?>!</a></li>
                        <li>
                            <a href="./backend/login.php?method=logout">Logout</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <?php
        require_once "common.php";
        $db = getConnection();
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['method']) && $_GET['method'] == 'delete') {
            $id = $_GET['id'];
            $sql = "delete from comments where id='{$id}'";
            $stmt = oci_parse($db, $sql);
            oci_execute($stmt);
            if ($stmt) {
                echo "<script>
            alert('delete success');
            window.location.href = 'admincomment.php';
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
                <div class="panel-heading">Comment List&nbsp; </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <th>Publish Time</th>
                        <th>Post title</th>
                        <th>Content</th>
                        <th>User</th>
                        <th>Operation</th>
                        </thead>
                        <?php


                        $sql = "SELECT TA.*,TB.username,TC.title FROM comments TA left join users TB ON TA.user_email=TB.email left join posts TC ON TA.post_id=TC.id";
                        $stmt = oci_parse($db, $sql);
                        oci_execute($stmt);
                        if ($stmt)
                            while (oci_fetch_array($stmt)) { ?>


                                <tr>
                                    <td><?= oci_result($stmt, "PUBLISH_TIME") ?></td>
                                    <td><?= oci_result($stmt, "TITLE") ?></td>
                                    <td><?= oci_result($stmt, "CONTENT") ?></td>
                                    <td><?= oci_result($stmt, "USERNAME") ?></td>
                                    <td>
                                        <a href="#" onclick="delete_comment('<?= oci_result($stmt, "ID") ?>')">Delete</a>
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
    function delete_comment(id) {
        if (confirm('are you sure to delete this?')) {
            window.location.href = 'admincomment.php?method=delete&id=' + id;
        }
    }
</script>
</html>
