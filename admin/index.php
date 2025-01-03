<?php
session_start();
?>

<?php
include('../lib/coreFunction.php');
$f = new CoreFunction();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
    header("Location: login.php");
}
?>

<?php
require('../config/route.php');
require('../config/path.php');
require('../partial/admin/header.php');
?>


<?php

if (!isset($_GET['page'])) {
    $page = '';
} else {
    $page = $_GET['page'];
}
foreach ($admin_route as $key => $value) {
    if ($key == $page) {
        require($value);
    }
}
?>


<?php
require('../partial/admin/footer.php');
?>  
