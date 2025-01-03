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
            <form action="<?= BASE_URL ?>page=cart" method="post">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all">
                                </div>
                            </th>
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
                                <td><input type="checkbox" class="form-check-input"></td>
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
                                        data-subtotal-id="subtotal-<?= $i ?>">
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
                <div class="d-flex mt-4 flex-row-reverse">
                    <button type="submit" name="update_cart" class="btn btn-primary">
                        <i class="fa-solid fa-pen"></i> Cập nhật
                    </button>
                    <button type="submit" name="cancel_cart" class="btn btn-secondary mx-4">
                        <i class="fa-solid fa-trash"></i> Hủy giỏ hàng
                    </button>
                    <button type="submit" name="checkout" class="btn btn-success">
                        <i class="fa-solid fa-check"></i> Thanh toán
                    </button>
                </div>
            </form>
        </div>
    <?php
    }
    ?>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Lấy tất cả các ô input số lượng
    const quantityInputs = document.querySelectorAll(".quantity");

    quantityInputs.forEach(input => {
        input.addEventListener("input", function () {
            const price = parseFloat(this.dataset.price); // Lấy giá sản phẩm từ thuộc tính data-price
            const quantity = parseInt(this.value); // Lấy số lượng mới
            const subtotalId = this.dataset.subtotalId; // Lấy ID của ô thành tiền cần cập nhật
            const subtotalElement = document.getElementById(subtotalId); // Tìm ô thành tiền

            if (!isNaN(quantity) && quantity > 0) {
                const subtotal = price * quantity;
                subtotalElement.textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(subtotal);
                updateTotal();
            }
        });
    });

    function updateTotal() {
        let total = 0;
        quantityInputs.forEach(input => {
            const price = parseFloat(input.dataset.price);
            const quantity = parseInt(input.value);
            if (!isNaN(quantity) && quantity > 0) {
                total += price * quantity;
            }
        });

        // Cập nhật tổng tiền
        const totalElement = document.getElementById("total-amount");
        if (totalElement) {
            totalElement.textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
        }
    }
});
</script>
