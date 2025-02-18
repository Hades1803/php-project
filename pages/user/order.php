<?php
$userId = $_SESSION['user']['id']; // Lấy ID của người dùng từ session
$sql = "SELECT * FROM `orders` WHERE user_id = '" . $userId . "' ORDER BY created_at DESC";
$result = $s->getAll($sql);
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Đơn Hàng Của Tôi</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Mã Đơn Hàng</th>
                <th scope="col">Ngày Đặt</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Tổng Tiền</th>
                <th scope="col">Chi Tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $order): ?>
                <tr>
                    <td>#<?= $order["id"] ?></td>
                    <td><?= date("d/m/Y H:i", strtotime($order["created_at"])) ?></td>
                    <td>
                        <span class="badge bg-<?= strtolower($order['status']) == 'completed' ? 'success' : (strtolower($order['status']) == 'pending' ? 'warning' : 'danger') ?>">
                            <?= $order["status"] ?>
                        </span>
                    </td>
                    <td><?= number_format($order["total_price"], 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <a href="<?= BASE_URL ?>page=orderDetail&id=<?= $order["id"] ?>" class="btn btn-primary btn-sm">Xem Chi Tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
