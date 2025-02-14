<?php
// Lấy danh sách đơn hàng và tên khách hàng từ bảng users
$sql = "SELECT o.id, o.order_date, o.total_price,o.status, u.name AS customer_name
        FROM orders o
        JOIN user u ON o.user_id = u.id";

$result = $f->getAll($sql);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Bảng hiển thị danh sách đơn hàng -->
            <h3 class="mb-4">Danh sách đơn hàng</h3>
            <table class="table table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Tình Trạng</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($result)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Không có dữ liệu đơn hàng nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($result as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']) ?></td>
                                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td><?= number_format($order['total_price'], 0, ',', '.') ?> VND</td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td>
                                    <a href="<?= BASE_ADMIN_URL?>page=order_detail&order_id=<?= $order['id'] ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
