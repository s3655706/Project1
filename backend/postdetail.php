<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Detail</title>
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
        $id = null;
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['id'])) {

            echo "URL error";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $id = $_GET['id'];

        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $content = ($_POST['content']);
            $post_id = ($_POST['post_id']);
            $time = date('Y-m-d h:i:s',time());
            $id = create_guid();
            $sql = "insert into comments(id,post_id,content,user_email,publish_time)
          values('{$id}','{$post_id}','{$content}','{$_SESSION['email']}',to_date('{$time}','YYYY-MM-DD HH24:MI:SS'))";
            $stmt = oci_parse($db, $sql);
            oci_execute($stmt);
            if ($stmt) {
                echo "<script>
            alert('add comment success');
            window.location.href = 'postdetail.php?id={$post_id}';
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
            <?php
            $sql = "SELECT TA.*,TB.username FROM posts TA LEFT JOIN users TB ON TA.user_email=TB.email WHERE TA.id='{$id}'";
            $stmt = oci_parse($db, $sql);
            oci_execute($stmt);
            if ($stmt)
                if (oci_fetch_array($stmt)) {  ?>

                <div class="col-sm-6 col-md-12">
                    <h3>Job Detail</h3>
                    <div class="thumbnail">
                        <div class="caption text-center">
                            <h4> <?= oci_result($stmt, "TITLE") ?> </h4>
                            
                            <hr>
                            <div>
                            <b> Job Type:</b>&nbsp;&nbsp;<?= oci_result($stmt,"POST_TYPE") == 2? 'Advertise job offers':'Apply for a job'; ?>
                            </div>
                            <hr>
                            <div>
                            <b>Job Field:</b>&nbsp;&nbsp;<?= $areas[oci_result($stmt,"AREA_ID")]  ; ?>
                            </div>
                            <hr>
                            <div>
                            <b>Education:</b>&nbsp;&nbsp;<?= $educations[oci_result($stmt,"EDUCATION_TYPE")]  ; ?>
                            </div>
                            <hr>
                            <b>Content:</b>&nbsp;&nbsp;<p><?= oci_result($stmt,'CONTENT'); ?></p>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Add comment</h4></div>
                <div class="panel-body">
                    <form class="form-horizontal" action="postdetail.php" method="post">
                        <input type="hidden" name="post_id" value="<?= $id ?>"/>
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">Comment:</label>
                            <div class="col-sm-10">
                                <textarea required name="content"
                                          class="form-control" id="content"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>
                <div class="panel-body">
                    <?php

                    $sql = "SELECT TA.*,TB.username FROM comments TA LEFT JOIN users TB ON TA.user_email=TB.email WHERE TA.post_id='{$id}'";
                    $stmt = oci_parse($db, $sql);
                    oci_execute($stmt);
                    if ($stmt)
                        if (oci_fetch_array($stmt)) {  ?>

                            <div class="media">

                                <div class="media-body" style="padding-left: 20px;">
                                    <?= oci_result($stmt, "CONTENT") ?>
                                    
                                </div>
                            </div>
                            <hr>
                        <?php } ?>

                </div>
            </div>

        </div>
    </div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>
