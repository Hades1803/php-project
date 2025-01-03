<?php
$email = $_POST['email'];
$pass = $_POST['pswd'];
$sql = "SELECT * FROM user WHERE email = '" . $email . "' AND password = '" . sha1($pass) . "';";
$result = $s->getOne($sql);

if (!is_null($result)) {
    $_SESSION['user'] = $result['username'];
    $_SESSION['userId'] = $result['id'];
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Đăng nhập thành công !!!",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php";
            }
        });
    </script>';
    exit();
    
} else {
    echo "Email hoặc password bị sai";
}

if (isset($_POST['remember'])) {
    setcookie("email", $email, time() + 3600 * 24 * 30, "/");
    setcookie("pswd", $pass, time() + 3600 * 24 * 30, "/"); 
} else {
    setcookie("email", "", time() - 3600, "/");
    setcookie("pswd", "", time() - 3600, "/");
}

?>
