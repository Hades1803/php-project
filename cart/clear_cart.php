<?php

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập']);
    exit();
}

unset($_SESSION['cart']);
unset($_SESSION['amount']);

echo json_encode(['status' => 'success', 'message' => 'Xóa toàn bộ giỏ hàng thành công']);
?>