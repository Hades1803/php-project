<?php



// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    echo '<div class="alert alert-warning text-center">Đăng nhập để xem giỏ hàng</div>';
    exit();
}

// Kiểm tra giỏ hàng rỗng
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo '<div class="alert alert-info text-center">Chưa có sản phẩm trong giỏ hàng</div>';
    exit();
}

$cart = $_SESSION["cart"];
$amount = $_SESSION["amount"];
$total = 0;

$txt = "(" . implode(",", $cart) . ")";
$sql = "SELECT * FROM product WHERE id IN $txt";
$result = $s->getAll($sql);
?>
<div class="row px-5 products">
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
                <?php foreach ($result as $index => $c):
                    $quantity = $amount[$index];
                    $subtotal = $c['price'] * $quantity;
                    $total += $subtotal;
                    ?>
                    <tr data-product-id="<?= $c['id'] ?>">
                        <td class="img-thumbnail" style="width: 100px; height: 100px;">
                            <img src="<?= $c['image'] ?>" alt="Product Image" class="img-fluid rounded">
                        </td>
                        <td><?= htmlspecialchars($c['product_name']) ?></td>
                        <td><?= number_format($c['price'], 0, ',', '.') ?>₫</td>
                        <td>
                            <input class="form-control text-center quantity" type="number" value="<?= $quantity; ?>" min="1"
                                data-price="<?= $c['price'] ?>" data-index="<?= $index ?>">
                        </td>
                        <td class="subtotal"><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-item" data-id="<?= $c['id'] ?>">
                                <i class="fa-solid fa-trash-can"></i> Xóa
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-secondary">
                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                    <td colspan="2" class="fw-bold text-success" id="total-amount">
                        <?= number_format($total, 0, ',', '.') ?>₫
                    </td>
                </tr>
            </tfoot>
        </table>
        <a href="<?= BASE_URL ?>page=confirm" class="btn btn-success">Đặt hàng</a>
    </div>
</div>

<!-- jQuery để xử lý cập nhật và xóa sản phẩm -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    $(".quantity").on("change", function () {
        let qty = parseInt($(this).val());
        if (qty < 1) {
            qty = 1;
            $(this).val(1);
        }

        let productId = $(this).closest("tr").data("product-id"); 
        let price = $(this).data("price");
        let subtotal = qty * price;
        $(this).closest("tr").find(".subtotal").text(subtotal.toLocaleString('vi-VN') + "₫");

        updateTotal();

        // Gửi số lượng mới lên server để cập nhật session
        $.ajax({
            url: "<?= BASE_URL?>page=update",
            type: "POST",
            data: { product_id: productId, quantity: qty },
            success: function (response) {
                console.log(response);
            }
        });
    });


        // Hàm cập nhật tổng tiền giỏ hàng
        function updateTotal() {
            let total = 0;
            $(".quantity").each(function () {
                let qty = parseInt($(this).val());
                let price = $(this).data("price");
                total += qty * price;
            });

            $("#total-amount").text(total.toLocaleString('vi-VN') + "₫");
        }
    });
</script>