<!-- Giỏ hàng -->
<div class="row px-5 products">
    <?php
    if (!isset($_SESSION['user'])) {
        echo '<div class="alert alert-warning text-center">Đăng nhập để xem giỏ hàng</div>';
        exit();
    }
    if (!isset($_SESSION['cart']) || $_SESSION['number_of_item'] == 0) {
        echo '<div class="alert alert-info text-center">Chưa có sản phẩm trong giỏ hàng</div>';
    } else {
    ?>
        <div class="col-12">
            <h2 class="text-center text-success my-4">Giỏ hàng</h2>
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cart = $_SESSION["cart"];
                    $a = $_SESSION["amount"];
                    $n = count($cart);
                    $txt = "(";
                    for ($i = 0; $i < $n; $i++) {
                        $txt .= "" . $cart[$i];
                        if ($i < $n - 1) {
                            $txt .= ",";
                        }
                    }
                    $txt .= ")";
                    
                    $sql = "SELECT * FROM product WHERE id IN " . $txt;
                    $result = $s->getAll($sql);
                    $i = 0;
                    $total = 0;

                    foreach ($result as $c):
                        $quantity = $a[$i];
                        $subtotal = $c['price'] * $quantity;
                    ?>
                        <tr>
                            <td class="img-thumbnail" style="width: 100px; height: 100px;">
                                <img src="<?= $c['image'] ?>" alt="Product Image" class="img-fluid rounded">
                            </td>
                            <td><?= htmlspecialchars($c['product_name']) ?></td>
                            <td><?= number_format($c['price'], 0, ',', '.') ?>₫</td>
                            <td>
                                <input 
                                    class="form-control text-center quantity" 
                                    type="number" 
                                    name="amount<?= $i ?>" 
                                    value="<?= $quantity; ?>" 
                                    min="1" 
                                    data-price="<?= $c['price'] ?>" 
                                    data-subtotal-id="subtotal-<?= $i ?>" 
                                    data-product-id="<?= $c['id'] ?>">
                            </td>
                            <td id="subtotal-<?= $i ?>"><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                            <td>
                                <a href="remove.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash-can"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php
                        $total += $subtotal;
                        $i++;
                    endforeach;
                    ?>
                </tbody>
                <tfoot>
                    <tr class="table-secondary">
                        <td colspan="5" class="text-end fw-bold">Tổng cộng:</td>
                        <td colspan="2" class="fw-bold text-success" id="total-amount"><?= number_format($total, 0, ',', '.') ?>₫</td>
                    </tr>
                </tfoot>
            </table>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmOrderModal">
                Đặt hàng
            </button>
        </div>
    <?php
    }
    ?>
</div>
<?php 
// Lấy thông tin người dùng hiện tại từ cơ sở dữ liệu
$userId = $_SESSION['userId'];
$sql = "SELECT * FROM user WHERE id = $userId";
$result = $s->getOne($sql);

?>
<!-- Modal Xác nhận đơn hàng -->
<div class="modal fade" id="confirmOrderModal" tabindex="-1" aria-labelledby="confirmOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmOrderModalLabel">Xác nhận đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?=BASE_URL ?>page=cart" method="post">
                    <h6>Thông tin người dùng</h6>
                    <p>Tên người dùng:  <?= htmlspecialchars($result['name']) ?></p>
                    <p>Số điện thoại:   <?= htmlspecialchars($result['phone']) ?></p>
                    <div class="form-group">
                        <label for="user-address">Địa chỉ:</label>
                        <input type="text" id="user-address" name="user_address" class="form-control" value="<?= htmlspecialchars($result['address']) ?>" required>
                    </div>

                    <h6>Thông tin đơn hàng</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="order-details">
                            <!-- Order details will be inserted here dynamically -->
                        </tbody>
                    </table>

                    <p><strong>Tổng cộng: </strong><span id="total-price"></span></p>

                    <div class="form-group">
                        <label for="payment-method" class="form-label">Chọn phương thức thanh toán</label>
                        <select name="payment_method" id="payment-method" class="form-select" required>
                            <option value="cash_on_delivery">Thanh toán khi nhận hàng</option>
                            <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                            <option value="e_wallet">Ví điện tử (Ví MoMo, ZaloPay,...)</option>
                        </select>
                    </div>

                    <div class="d-flex mt-4 flex-row-reverse">
                        <button type="submit" name="checkout" class="btn btn-success">
                            <i class="fa-solid fa-check"></i> Đặt hàng
                        </button>
                        <button type="submit" name="cancel_cart" class="btn btn-secondary mx-4">
                            <i class="fa-solid fa-trash"></i> Hủy giỏ hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Thêm các thư viện cần thiết cho Bootstrap Modal -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>


document.getElementById('confirmOrderModal').addEventListener('show.bs.modal', function () {
    let cart = <?php echo json_encode($_SESSION['cart']); ?>;
    let amount = <?php echo json_encode($_SESSION['amount']); ?>;
    let cartItems = document.getElementById('order-details');
    let totalPrice = 0;
    cartItems.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

    cart.forEach((productId, index) => {
        let product = <?php echo json_encode($s->getAll("SELECT * FROM product WHERE id IN (" . implode(",", $_SESSION['cart']) . ")")); ?>;
        let productInfo = product.find(item => item.id === productId);
        let quantity = amount[index];
        let subtotal = productInfo.price * quantity;
        totalPrice += subtotal;

        let row = document.createElement('tr');
        row.innerHTML = `
            <td>${productInfo.product_name}</td>
            <td>${productInfo.price}</td>
            <td>${quantity}</td>
            <td>${subtotal}</td>
        `;
        cartItems.appendChild(row);
    });

    document.getElementById('total-price').textContent = totalPrice;
});
document.getElementById('confirmOrderModal').addEventListener('show.bs.modal', function () {
    updateOrderDetails();
});

</script>


<?php
if (isset($_POST['checkout'])) {
    // Kiểm tra phương thức thanh toán
    if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
        echo '<div class="alert alert-danger text-center">Vui lòng chọn phương thức thanh toán</div>';
        exit();
    }
    $payment_method = $_POST['payment_method'];
    $user_id = $_SESSION['userId']; // Lấy thông tin người dùng từ session
    $cart = $_SESSION['cart'];
    $amount = $_SESSION['amount'];
    $total = 0; // Khởi tạo tổng tiền
    $address = $_POST['user_address'];
    // Dữ liệu cho đơn hàng trước khi thêm vào bảng orders
    $order_data = array(
        'user_id' => $user_id,
        'total_price' => $total, // Thêm tạm giá trị 0 ở đây, sẽ cập nhật sau
        'shipping_address' => $address,
        'payment_method' => $payment_method,
        'payment_status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    );

    // Thêm đơn hàng vào bảng orders
    $s->addRecord('orders', $order_data);

    // Lấy ID của đơn hàng vừa thêm
    $sql = "SELECT id FROM orders WHERE user_id = $user_id AND created_at = '{$order_data['created_at']}' ORDER BY id DESC LIMIT 1";
    $result = $s->getOne($sql);
    $order_id = $result['id'];

    // Lưu chi tiết đơn hàng vào bảng order_details và tính tổng
    foreach ($cart as $index => $product_id) {
        $quantity = $amount[$index];
        $product_query = "SELECT * FROM product WHERE id = '$product_id'";
        $product = $s->getOne($product_query);
        $subtotal = $product['price'] * $quantity;
        $total += $subtotal; // Cộng dồn vào tổng tiền

        // Dữ liệu cho chi tiết đơn hàng
        $order_detail_data = array(
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $product['price'],
            'total_price' => $subtotal
        );

        // Thêm chi tiết vào bảng order_details
        $s->addRecord('order_detail', $order_detail_data);
    }

    // Cập nhật tổng giá trị đơn hàng vào bảng orders sau khi tính toán
    $update_order_data = array(
        'total_price' => $total // Cập nhật tổng tiền vào bảng orders
    );

    // Cập nhật tổng giá trị đơn hàng
    $sql="UPDATE orders SET total_price = '{$total}' WHERE id = {$order_id}";
    $s->setQuery($sql);

    // Xóa giỏ hàng sau khi thanh toán thành công
    unset($_SESSION['cart']);
    unset($_SESSION['amount']);
    unset($_SESSION['number_of_item']);

    // Thông báo thanh toán thành công bằng SweetAlert
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Đặt hàng thành công!',
            text: 'Đơn hàng của bạn đang được xử lý.',
            confirmButtonText: 'OK',
            willClose: () => {
                window.location.href = 'http://localhost/NguyenAnhQuoc/index.php?page=cart'; // Chỉnh sửa theo trang bạn muốn
            }
        });
    </script>";
    exit();
}

?>


