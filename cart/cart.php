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
                            <img src="/NguyenAnhQuoc/asset/images/<?= $c['image'] ?>" alt="Product Image"
                                class="img-fluid rounded">
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
        <button id="clear-cart" class="btn btn-danger">Xóa toàn bộ giỏ hàng</button>
    </div>
</div>

<!-- jQuery để xử lý cập nhật và xóa sản phẩm -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                url: "<?= BASE_URL ?>page=update",
                type: "POST",
                data: { product_id: productId, quantity: qty },
                success: function (response) {
                    console.log(response);
                }
            });
        });

        // Xóa từng sản phẩm
        $(".remove-item").on("click", function () {
            let productId = $(this).data("id");

            // Sử dụng SweetAlert thay vì confirm
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Sản phẩm này sẽ bị xóa khỏi giỏ hàng.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có, xóa nó!',
                cancelButtonText: 'Hủy',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= BASE_URL ?>page=removeItem",
                        type: "POST",
                        data: { product_id: productId },
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire(
                                    'Đã xóa!',
                                    'Sản phẩm đã được xóa khỏi giỏ hàng.',
                                    'success'
                                ).then(() => {
                                    window.location.href = 'http://localhost/NguyenAnhQuoc/index.php?page=cart'; 
                                });
                            } else {
                                Swal.fire(
                                    'Lỗi!',
                                    res.message,
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });

        // Xóa toàn bộ giỏ hàng
        $("#clear-cart").on("click", function () {
            // Sử dụng SweetAlert thay vì confirm
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Toàn bộ giỏ hàng sẽ bị xóa.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có, xóa tất cả!',
                cancelButtonText: 'Hủy',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= BASE_URL ?>page=clearCart",
                        type: "POST",
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire(
                                    'Đã xóa!',
                                    'Giỏ hàng của bạn đã được xóa.',
                                    'success'
                                ).then(() => {
                                    window.location.href = 'http://localhost/NguyenAnhQuoc/index.php?page=cart'; // Reload trang
                                });
                            } else {
                                Swal.fire(
                                    'Lỗi!',
                                    res.message,
                                    'error'
                                );
                            }
                        }
                    });
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