<?php
@session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['method'] == 'logout') {
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    session_destroy();
    echo "
    <script>
    window.location.href='../login.php';
    
</script>
    ";
}
