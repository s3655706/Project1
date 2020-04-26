<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>main</title>
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
        $type = $_SESSION['user_type'];
        $work = $_SESSION['area_id'];
        $eduction = $_SESSION['education'];
        $title = $_SESSION['description'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $type = $_POST['type'];
            $work = $_POST['work'];
            $eduction = $_POST['eduction'];
            $title = $_POST['title'];


        }
        ?>

    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="col-md-12">


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Search Post</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="main.php" method="post">
                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">Post Type</label>
                            <div class="col-sm-10 ">
                                <select name="type" class="form-control" id="type">
                                    <option <?= $type!=null && $type =='0' ? 'selected':'' ?> value="0">None</option>
                                    <option <?= $type!=null && $type =='1' ? 'selected':'' ?> value="1">Apply</option>
                                    <option <?= $type!=null && $type =='2' ? 'selected':'' ?> value="2">Recruitment</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="work" class="col-sm-2 control-label">Work Domain</label>
                            <div class="col-sm-10 ">
                                <select name="work" class="form-control" id="work">
                                    <option <?= $work!=null && $work =='0' ? 'selected':'' ?>   value="0">None</option>
                                    <option <?= $work!=null && $work =='1' ? 'selected':'' ?>   value="1">Computer Science</option>
                                    <option <?= $work!=null && $work =='2' ? 'selected':'' ?>   value="2">Construction Engineering</option>
                                    <option <?= $work!=null && $work =='3' ? 'selected':'' ?>   value="3">Art</option>
                                    <option <?= $work!=null && $work =='4' ? 'selected':'' ?>   value="4">Financial</option>
                                    <option <?= $work!=null && $work =='5' ? 'selected':'' ?>   value="5">Education</option>
                                    <option <?= $work!=null && $work =='6' ? 'selected':'' ?>   value="6">Transport Engineering</option>
                                    <option <?= $work!=null && $work =='7' ? 'selected':'' ?>   value="7">Medicine</option>
                                    <option <?= $work!=null && $work =='8' ? 'selected':'' ?>   value="8">Administration</option>
                                    <option <?= $work!=null && $work =='9' ? 'selected':'' ?>   value="9">Others</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="eduction" class="col-sm-2 control-label">Education Requirement</label>
                            <div class="col-sm-10 ">
                                <select name="eduction" class="form-control" id="eduction">
                                    <option  <?= $eduction!=null && $eduction =='0' ? 'selected':'' ?>  value="0">None</option>
                                    <option  <?= $eduction!=null && $eduction =='1' ? 'selected':'' ?>  value="1">No Academic Requirements</option>
                                    <option  <?= $eduction!=null && $eduction =='2' ? 'selected':'' ?>  value="2">Junior College</option>
                                    <option  <?= $eduction!=null && $eduction =='3' ? 'selected':'' ?>  value="3">Undergraduate</option>
                                    <option  <?= $eduction!=null && $eduction =='4' ? 'selected':'' ?>  value="4">Postgraduate and Above</option>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Post Title</label>
                            <div class="col-sm-10">
                                <input value="<?= $title==null ? '':$title ?>" name="title" type="text" class="form-control" id="title" placeholder="title">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-12">


            <div class="panel panel-default">
                <div class="panel-heading">Post List</div>
                <div class="panel-body">

                    <?php


                    $order_by = "";
                    $sql = "SELECT * FROM (SELECT TA.*,TB.username FROM posts TA LEFT JOIN users TB ON TA.user_email=TB.email) temp ";
                    $flag = false;
                    if (($type != null && $type != 0) || ($work != null&& $work != 0) ||($eduction != null&& $eduction != 0)||($title != null)) {
                        $sql = $sql." WHERE 1 = 0 ";
                        $order_by = " ORDER BY ";
                        $flag = true;
                    }

                    if ($type != null && $type != 0) {
                        $sql = $sql." OR post_type={$type}";
                        $order_by = $order_by." (case when post_type={$type} then 0 else 1 end),";

                    }
                    if ($work != null&& $work != 0) {
                        $sql =  $sql. " OR area_id={$work}";
                        $order_by = $order_by." (case when area_id={$work} then 0 else 1 end),";
                    }
                    if ($eduction != null&& $eduction != 0) {
                        $sql =  $sql." OR education_type={$eduction}";
                        $order_by = $order_by." (case when education_type={$eduction} then 0 else 1 end),";
                    }
                    if ($title != null) {
                        $sql =  $sql. " OR title Like '%{$title}%'";
                        $order_by = $order_by." (case when title Like '%{$title}%' then 0 else 1 end),";
                    }
                    if($flag) {
                        $order_by = $order_by."title";
                    }
                    $sql = $sql.$order_by;

                    $stmt = oci_parse($db, $sql);
                    oci_execute($stmt);
                    if ($stmt)
                        while (oci_fetch_array($stmt)) {

                     ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <div class="caption">
                                        <h3><a href="#"><?= oci_result($stmt,"TITLE") ?></a></h3>
                                        <hr>
                                        <div>
                                            类型:<?= oci_result($stmt,"POST_TYPE") == 2?'应聘':'招募'; ?>
                                        </div>
                                        <hr>
                                        <div>
                                            工作:<?= $areas[oci_result($stmt,"AREA_ID")]  ; ?>
                                        </div>
                                        <hr>
                                        <div>
                                            工作:<?= $educations[oci_result($stmt,"EDUCATION_TYPE")]  ; ?>
                                        </div>
                                        <hr>
                                        <p><?= oci_result($stmt,'CONTENT'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    ?>


                </div>
            </div>

        </div>
    </div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>
