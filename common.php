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
function create_guid() {
    static $guid = '';
    $uid = uniqid("", true);
    $data = '';
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = '{' .
        substr($hash,  0,  8) .
        '-' .
        substr($hash,  8,  4) .
        '-' .
        substr($hash, 12,  4) .
        '-' .
        substr($hash, 16,  4) .
        '-' .
        substr($hash, 20, 12) .
        '}';
    return $guid;
}
$areas = [
    'None',
    'Computer Science',
    'Construction Engineering',
    'Art',
    'Financial',
    'Education',
    'Transport Engineering',
    'Medicine',
    'Administration',
    'Others'];

$educations =
    ['None',
        'High school and Below',
        'Junior College',
        'Undergraduate',
        'Postgraduate and Above'];