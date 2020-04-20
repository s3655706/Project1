<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Addpost</title>
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post_type = ($_POST['post_type']);
            $area_id = ($_POST['area_id']);
            $eduction_type = ($_POST['eduction_type']);
            $title = ($_POST['title']);
            $content = ($_POST['content']);
            $time = date('Y-m-d h:i:s');
            $id = create_guid();
            $sql = "insert into posts(id,title,content,publish_time,area_id,post_type,education_type,user_email) 
          values('{$id}','{$title}','{$content}',to_date('{$time}','YYYY-MM-DD HH24:MI:SS'),{$area_id},{$post_type},{$eduction_type},'{$_SESSION['email']}')";
            $stmt = oci_parse($db, $sql);
            oci_execute($stmt);
            if ($stmt) {
                echo "<script>
                    alert('add post success');
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
                <div class="panel-heading">Publish a new post:</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="addpost.php" method="post">
                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">Post Type</label>
                            <div class="col-sm-10 ">
                                <select name="post_type" class="form-control" id="type">
                                    <option value="1">Apply</option>
                                    <option value="2"> Recruitment</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="work" class="col-sm-2 control-label">Work Domain</label>
                            <div class="col-sm-10 ">
                                <select name="area_id" class="form-control" id="work">
                                    <option value="1">Computer Science</option>
                                    <option value="2">Construction Engineering</option>
                                    <option value="3">Art</option>
                                    <option value="4">Financial</option>
                                    <option value="5">Education</option>
                                    <option value="6">Transport Engineering</option>
                                    <option value="7">Medicine</option>
                                    <option value="8">Administration</option>
                                    <option value="9">Others</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="eduction" class="col-sm-2 control-label">Education Requirement</label>
                            <div class="col-sm-10 ">
                                <select name="eduction_type" class="form-control" id="eduction">
                                    <option value="1"> No Academic Requirements</option>
                                    <option value="2"> Junior College</option>
                                    <option value="3"> Undergraduate</option>
                                    <option value="4"> Postgraduate and Above</option>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Post's title</label>
                            <div class="col-sm-10">
                                <input required name="title" type="text"
                                       class="form-control" id="title" placeholder="title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">Content</label>
                            <div class="col-sm-10">
                                <textarea required name="content"
                                          class="form-control" id="content"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Publish</button>
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
