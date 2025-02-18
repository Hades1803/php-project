<?php

header('Content-Type: application/json'); // Đặt header JSON

// Kiểm tra phương thức yêu cầu
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức không hợp lệ']);
    exit();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập']);
    exit();
}

// Kiểm tra product_id
if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin sản phẩm hoặc ID không hợp lệ']);
    exit();
}

$product_id = $_POST['product_id'];

// Kiểm tra và xóa sản phẩm
if (isset($_SESSION['cart'])) {
    $index = array_search($product_id, $_SESSION['cart']);
    if ($index !== false) {
        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$index]);
        // Xóa lượng sản phẩm tương ứng
        unset($_SESSION['amount'][$index]);
        $_SESSION['number_of_item']--;
        // Đặt lại chỉ số của mảng
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        $_SESSION['amount'] = array_values($_SESSION['amount']);
        echo json_encode(['status' => 'success', 'message' => 'Xóa sản phẩm thành công']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Giỏ hàng trống']);
}

?>