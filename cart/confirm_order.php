<?php

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];
$sql = "SELECT * FROM user WHERE id = $userId";
$user = $s->getOne($sql);

// Lấy thông tin giỏ hàng từ session
$cart = $_SESSION['cart'];
$amount = $_SESSION['amount'];
$total = 0;

// Lấy sản phẩm trong giỏ hàng
$txt = "(" . implode(",", $cart) . ")";
$sql = "SELECT * FROM product WHERE id IN $txt";
$products = $s->getAll($sql);
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Xác nhận đơn hàng</h2>

    <div class="card p-4 mb-4">
        <h4>Thông tin người dùng</h4>
        <p><strong>Tên:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <form action="<?= BASE_URL?>page=process" method="post">
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ:</label>
                <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($user['address']) ?>" required>
            </div>

            <h4>Thông tin đơn hàng</h4>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $p): 
                        $subtotal = $p['price'] * $amount[$index];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($p['product_name']) ?></td>
                        <td><?= number_format($p['price'], 0, ',', '.') ?>₫</td>
                        <td><?= $amount[$index] ?></td>
                        <td><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td><strong><?= number_format($total, 0, ',', '.') ?>₫</strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="mb-3">
                <label for="payment" class="form-label">Chọn phương thức thanh toán:</label>
                <select name="payment_method" id="payment" class="form-select">
                    <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                    <option value="Chuyển khoản ngân hàng">Chuyển khoản ngân hàng</option>
                    <option value="Ví điện tử">Ví điện tử</option>
                </select>
            </div>

            <button type="submit" name="checkout" class="btn btn-primary w-100">Xác nhận đặt hàng</button>
        </form>
    </div>
</div>
