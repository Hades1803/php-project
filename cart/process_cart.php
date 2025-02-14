<?php


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['checkout'])) {
    if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
        echo '<div class="alert alert-danger text-center">Vui lòng chọn phương thức thanh toán</div>';
        exit();
    }

    $payment_method = $_POST['payment_method'];
    $user_id = $_SESSION['userId'];
    $cart = $_SESSION['cart'];
    $amount = $_SESSION['amount'];
    $address = $_POST['address'];

    // ✅ Tính tổng tiền trước khi thêm đơn hàng
    $total = 0;
    foreach ($cart as $index => $product_id) {
        $product = $s->getOne("SELECT price FROM product WHERE id = '$product_id'");
        $subtotal = $product['price'] * $amount[$index];
        $total += $subtotal;
    }

    // ✅ Lưu đơn hàng vào bảng orders
    $order_data = array(
        'user_id' => $user_id,
        'total_price' => $total, 
        'shipping_address' => $address,
        'payment_method' => $payment_method,
        'payment_status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    );
    $s->addRecord('orders', $order_data);

    // ✅ Lấy ID của đơn hàng vừa tạo
    $order_id = $s->getOne("SELECT LAST_INSERT_ID() AS id")['id'];

    // ✅ Thêm chi tiết đơn hàng vào bảng order_details
    foreach ($cart as $index => $product_id) {
        $quantity = $amount[$index];
        $product = $s->getOne("SELECT price FROM product WHERE id = '$product_id'");
        $subtotal = $product['price'] * $quantity;

        $order_detail_data = array(
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $product['price'],
            'total_price' => $subtotal
        );

        // Chèn vào order_details và kiểm tra lỗi
        $sql = "INSERT INTO order_detail (order_id, product_id, quantity, price, total_price) 
        VALUES ('$order_id', '$product_id', '$quantity', '{$product['price']}', '$subtotal')";

        $result = $s->setQuery($sql);
        if (!$result) {
            die("Lỗi khi thêm vào order_details: " . mysqli_error($s->conn));
        }
    }

    // ✅ Xóa giỏ hàng sau khi đặt hàng thành công
    unset($_SESSION['cart']);
    unset($_SESSION['amount']);
    unset($_SESSION['number_of_item']);

    // ✅ Hiển thị thông báo đặt hàng thành công
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Đặt hàng thành công!',
            text: 'Đơn hàng của bạn đang được xử lý.',
            confirmButtonText: 'OK',
            willClose: () => {
                window.location.href = 'index.php?page=cart';
            }
        });
    </script>";
    exit();
}
?>
