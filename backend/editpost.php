<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editpost</title>
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
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post_type = ($_POST['post_type']);
            $area_id = ($_POST['area_id']);
            $eduction_type = ($_POST['eduction_type']);
            $title = ($_POST['title']);
            $content = ($_POST['content']);

            $id = ($_POST['id']);
            $sql = "UPDATE posts SET 
            title='{$title}',
            content='{$content}',
            area_id={$area_id},
            post_type={$post_type},
            education_type={$eduction_type} WHERE id='{$id}'";
            $stmt = oci_parse($db, $sql);
            oci_execute($stmt);

            if ($stmt) {
                echo "<script>
                    alert('update post success');
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
            <?php
            $sql = "SELECT * FROM posts WHERE id='{$id}'";
            $stmt = oci_parse($db, $sql);
            oci_execute($stmt);
            if ($stmt)
                if (oci_fetch_array($stmt)) { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit a post:</div>
                        <div class="panel-body">
                            <form class="form-horizontal" action="editpost.php" method="post">
                                <input type="hidden" name="id" value="<?= oci_result($stmt, "ID") ?>"/>
                                <div class="form-group">
                                    <label for="type" class="col-sm-2 control-label">Job Type</label>
                                    <div class="col-sm-10 ">
                                        <select name="post_type" class="form-control" id="type">
                                            <option <?= oci_result($stmt, "POST_TYPE") == 1 ? 'selected' : '' ?>
                                                    value="1">Apply for a job
                                            </option>
                                            <option <?= oci_result($stmt, "POST_TYPE") == 2 ? 'selected' : '' ?>
                                                    value="2"> Advertise job offers
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="work" class="col-sm-2 control-label">Job Field</label>
                                    <div class="col-sm-10 ">
                                        <select name="area_id" class="form-control" id="work">
                                            <option <?= oci_result($stmt, "AREA_ID") == 1 ? 'selected' : '' ?>
                                                    value="1">Computer Science
                                            </option>
                                            <option <?= oci_result($stmt, "AREA_ID") == 2 ? 'selected' : '' ?>
                                                    value="2">Construction Engineering
                                            </option>
                                            <option <?= oci_result($stmt, "AREA_ID") == 3 ? 'selected' : '' ?>
                                                    value="3">Art
                                            </option>
                                            <option <?= oci_result($stmt, "AREA_ID") == 4 ? 'selected' : '' ?>
                                                    value="4">Financial
                                            </option>
                                            <option <?= oci_result($stmt, "AREA_ID") == 5 ? 'selected' : '' ?>
                                                    value="5">Education
                                            </option>
                                            <option <?= oci_result($stmt, "AREA_ID") == 6 ? 'selected' : '' ?>
                                                    value="6">Transport Engineering
                                            </option>
                                            <option <?= oci_result($stmt, "AREA_ID") == 7 ? 'selected' : '' ?>
                                                    value="7">Medicine
                                            </option>
                                            <option <?= oci_result($stmt, "AREA_ID") == 8 ? 'selected' : '' ?>
                                                    value="8">Administration
                                            </option>
                                            <option <?= oci_result($stmt, "AREA_ID") == 9 ? 'selected' : '' ?>
                                                    value="9">Others
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="eduction" class="col-sm-2 control-label">Education</label>
                                    <div class="col-sm-10 ">
                                        <select name="eduction_type" class="form-control" id="eduction">
                                            <option <?= oci_result($stmt, "EDUCTION_TYPE") == 1 ? 'selected' : '' ?>
                                                    value="1"> High school and Below
                                            </option>
                                            <option <?= oci_result($stmt, "EDUCTION_TYPE") == 2 ? 'selected' : '' ?>
                                                    value="2"> Junior College
                                            </option>
                                            <option <?= oci_result($stmt, "EDUCTION_TYPE") == 3 ? 'selected' : '' ?>
                                                    value="3"> Undergraduate
                                            </option>
                                            <option <?= oci_result($stmt, "EDUCTION_TYPE") == 4 ? 'selected' : '' ?>
                                                    value="4"> Postgraduate and Above
                                            </option>

                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Job Title</label>
                                    <div class="col-sm-10">
                                        <input required name="title" type="text"
                                               class="form-control" value="<?= oci_result($stmt, "TITLE") ?>" id="title"
                                               placeholder="title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="content" class="col-sm-2 control-label">Content</label>
                                    <div class="col-sm-10">
                                <textarea required name="content"
                                          class="form-control"
                                          id="content"><?= oci_result($stmt, "CONTENT") ?></textarea>
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
                <?php } ?>
        </div>
    </div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>
