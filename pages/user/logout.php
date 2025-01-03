<?php

// Hủy phiên đăng nhập
session_unset();
session_destroy();

// Chuyển hướng về trang chủ hoặc trang đăng nhập
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script>
    Swal.fire({
        icon: "success",
        title: "Đăng xuất thành công!",
        text: "Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.",
        confirmButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "index.php";
        }
    });
</script>';
exit();

?>