<?php
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    $_SESSION['amount'] = array();
    $_SESSION['number_of_item'] = 0;
}

$id = $_GET['id'];

$k = array_search($id, $_SESSION['cart']);
if($k === false) {
    array_push($_SESSION['cart'], $id);
    array_push($_SESSION['amount'], 1);
    $_SESSION['number_of_item']++;
} else {
    $_SESSION['amount'][$k]++;
}
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script>
    Swal.fire({
        icon: "success",
        title: "Thêm vào giỏ hàng thành công!",
        showConfirmButton: true,
        confirmButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "http://localhost/NguyenAnhQuoc/index.php?page=products"; 
        }
    });
</script>';
exit();
?>
