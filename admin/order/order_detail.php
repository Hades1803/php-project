<?php
// Lấy order_id từ tham số URL
$order_id = $_GET['order_id'] ?? 0;

// Lấy thông tin đơn hàng
$sql = "SELECT * FROM orders WHERE id = '" . $order_id . "'";
$order = $f->getOne($sql);

// Kiểm tra nếu admin thay đổi trạng thái đơn hàng
$statusUpdated = false;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['status'])) {
    $new_status = htmlspecialchars($_POST['status']); // Tránh lỗi SQL Injection
    $sql = "UPDATE orders SET status = '" . $new_status . "' WHERE id = '" . $order_id . "'";
    $f->setQuery($sql);
    $statusUpdated = true;
}

// Lấy danh sách sản phẩm trong đơn hàng
$sql = "SELECT od.*, p.product_name AS product_name
        FROM order_detail od
        JOIN product p ON od.product_id = p.id
        WHERE od.order_id = '" . $order_id . "'";
$order_details = $f->getAll($sql);
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

    <!-- Form cập nhật trạng thái đơn hàng -->
    <form method="POST" id="statusForm">
        <label for="status" class="fw-bold">Cập nhật trạng thái đơn hàng:</label>
        <select name="status" id="status" class="form-control" onchange="confirmUpdate()">
            <option value="Chờ xử lý" <?= ($order['status'] == "Chờ xử lý") ? 'selected' : '' ?>>Chờ xử lý</option>
            <option value="Đang xử lý" <?= ($order['status'] == "Đang xử lý") ? 'selected' : '' ?>>Đang xử lý</option>
            <option value="Đã giao hàng" <?= ($order['status'] == "Đã giao hàng") ? 'selected' : '' ?>>Đã giao hàng</option>
            <option value="Hoàn thành" <?= ($order['status'] == "Hoàn thành") ? 'selected' : '' ?>>Hoàn thành</option>
            <option value="Đã hủy" <?= ($order['status'] == "Đã hủy") ? 'selected' : '' ?>>Đã hủy</option>
        </select>
    </form>

    <a href="<?= BASE_ADMIN_URL ?>page=orders" class="btn btn-secondary mt-3">Quay lại danh sách đơn hàng</a>
</div>

<!-- SweetAlert2 để hiển thị thông báo -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmUpdate() {
    Swal.fire({
        title: "Xác nhận cập nhật?",
        text: "Bạn có chắc muốn thay đổi trạng thái đơn hàng không?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Cập nhật",
        cancelButtonText: "Hủy bỏ"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("statusForm").submit();
        }
    });
}

// Hiển thị thông báo nếu cập nhật thành công
<?php if ($statusUpdated): ?>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Cập nhật thành công!",
            text: "Trạng thái đơn hàng đã được thay đổi.",
            icon: "success",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "<?= BASE_ADMIN_URL ?>page=order_detail&order_id=<?= $order['id'] ?>";
        });
    });
<?php endif; ?>
</script>
