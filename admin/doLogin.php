<?php
session_start();
include('../lib/coreFunction.php');
$f = new CoreFunction();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $pass = $_POST['pswd'];
    $sql = "SELECT * FROM user WHERE email = '".$email."' AND password = '". sha1($pass)."' AND role = 'admin'";
    $result = $f->getOne($sql);
    //var_dump($result);
    if(!is_null($result)){
        $_SESSION['admin'] = $result['username'];
        header("Location: index.php");
    }
    else{
        header("Location: login.php");
    }
}
?>
