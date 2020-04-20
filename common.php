<?php



$username = 's3636136';
$password = '15006760906ldl';
$servername = 'talsprddb01.int.its.rmit.edu.au';
$servicename = 'CSAMPR1.ITS.RMIT.EDU.AU';

$connection = $servername."/".$servicename;
$db = null;
$db = oci_connect($username,
$password,
$connection);
function getConnection()
{
    global $db;
    if ($db != null) {
        return $db;
    } else {
            echo "An error occurred connecting to the database";
            exit;
  
    }

}
