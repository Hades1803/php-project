<?php
// Lấy order_id từ tham số URL
$order_id = $_GET['id'] ?? 0;

// Lấy thông tin đơn hàng
$sql = "SELECT * FROM orders WHERE id = '" . $order_id . "' AND user_id = '" . $_SESSION['user']['id'] . "'"; // Đảm bảo là đơn hàng của người dùng hiện tại
$order = $s->getOne($sql);

// Nếu không tìm thấy đơn hàng
if (!$order) {
    echo "<p class='text-danger'>Không tìm thấy đơn hàng này hoặc không phải đơn hàng của bạn.</p>";
    exit;
}

// Lấy danh sách sản phẩm trong đơn hàng
$sql = "SELECT od.*, p.product_name AS product_name
        FROM order_detail od
        JOIN product p ON od.product_id = p.id
        WHERE od.order_id = '" . $order_id . "'";
$order_details = $s->getAll($sql);
?>

<div class="container mt-5">
    <h3>Chi tiết đơn hàng #<?= htmlspecialchars($order_id) ?></h3>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($order_details)): ?>
                <tr>
                    <td colspan="4" class="text-center">Không có sản phẩm trong đơn hàng này.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($order_details as $detail): ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['product_name']) ?></td>
                        <td><?= htmlspecialchars($detail['quantity']) ?></td>
                        <td><?= number_format($detail['price'], 0, ',', '.') ?> VND</td>
                        <td><?= number_format($detail['quantity'] * $detail['price'], 0, ',', '.') ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Hiển thị trạng thái hiện tại -->
    <p><strong>Trạng thái đơn hàng:</strong> <?= htmlspecialchars($order['status']) ?></p>

    <!-- Hiển thị tổng tiền -->
    <p><strong>Tổng tiền:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> VND</p>

    <a href="<?= BASE_URL ?>page=order" class="btn btn-secondary mt-3">Quay lại danh sách đơn hàng</a>
</div>

