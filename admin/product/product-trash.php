<?php

require('../lib/paginator.php');
$items_per_page = 2;


$page = isset($_GET['currentPage']) ? $_GET['currentPage'] : 1;
$start_from = ($page - 1) * $items_per_page;


$sql_count = "SELECT COUNT(*) AS total FROM product p WHERE p.trash = 1";
$total_result = $f->getAll($sql_count);
$total_items = $total_result[0]['total'];

// Tạo đối tượng phân trang
$paginator = new Paginator(array(
    'base_url' => BASE_ADMIN_URL . "page=product-trash", 
    'total_rows' => $total_items,               
    'per_page' => $items_per_page,             
    'cur_page' => $page                         
));

$sql = "SELECT p.*, c.category_name FROM product p LEFT JOIN category c ON p.cat_id = c.id WHERE p.trash = 1 LIMIT $start_from, $items_per_page";
$result = $f->getAll($sql);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a href="index.php?page=products" class="btn btn-primary mb-3">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách sản phẩm
            </a>
            <table class="table table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Khôi phục</th>
                        <th>Xóa vĩnh viễn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $value): ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['product_name'] ?></td>
                            <td><?= $value['category_name'] ?></td>
                            <td><?= $value['status'] == 1 ? 'Hiện' : 'Ẩn' ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                   data-bs-target="#restoreProductModal"
                                   onclick="setRestoreProductId(<?= $value['id'] ?>)">
                                    <i class="fas fa-undo"></i> Khôi phục
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                   data-bs-target="#permanentDeleteProductModal"
                                   onclick="setDeleteProductId(<?= $value['id'] ?>)">
                                    <i class="fas fa-trash-alt"></i> Xóa vĩnh viễn
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- Phân trang -->
            <?php echo $paginator->createLinks(); ?>
        </div>
    </div>
</div>

<!-- Modal Khôi phục sản phẩm -->
<div class="modal fade" id="restoreProductModal" tabindex="-1" aria-labelledby="restoreProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreProductModalLabel">Khôi phục sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn khôi phục sản phẩm này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a id="confirmRestoreProductButton" href="#" class="btn btn-success">Khôi phục</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xóa vĩnh viễn sản phẩm -->
<div class="modal fade" id="permanentDeleteProductModal" tabindex="-1" aria-labelledby="permanentDeleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permanentDeleteProductModalLabel">Xóa vĩnh viễn sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa vĩnh viễn sản phẩm này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a id="confirmPermanentDeleteProductButton" href="#" class="btn btn-danger">Xóa vĩnh viễn</a>
            </div>
        </div>
    </div>
</div>
<?php
// Xử lý khôi phục sản phẩm
if (isset($_GET['restore_id'])) {
    $id = $_GET['restore_id'];

    // Khôi phục sản phẩm từ thùng rác
    $f->restoreRecord("product", $id);

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Thành công!',
                text: 'Sản phẩm đã được khôi phục!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Đóng Swal trước khi reload trang
                    Swal.close();
                    window.location.href = 'http://localhost/NguyenAnhQuoc/admin/index.php?page=product-trash';
                }
            });
        });
    </script>
    ";
}

// Xử lý xóa vĩnh viễn sản phẩm
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Kiểm tra xem sản phẩm có trong bảng đơn hàng không
    $sql_check_order = "SELECT COUNT(*) FROM order_detail WHERE product_id = $id";
    $result_check_order = $f->getAll($sql_check_order);

    if ($result_check_order[0]['COUNT(*)'] > 0) {
        // Sản phẩm đã có trong đơn hàng, không cho phép xóa
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Sản phẩm này không thể xóa vì đã có trong đơn hàng.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Đóng Swal trước khi reload trang
                        Swal.close();
                        window.location.href = 'http://localhost/NguyenAnhQuoc/admin/index.php?page=product-trash';
                    }
                });
            });
        </script>
        ";
    } else {
        // Xóa vĩnh viễn sản phẩm nếu không có trong đơn hàng
        $f->deleteRecord("product", $id);

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Sản phẩm đã được xóa vĩnh viễn!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Đóng Swal trước khi reload trang
                        Swal.close();
                        window.location.href = 'http://localhost/NguyenAnhQuoc/admin/index.php?page=product-trash';
                    }
                });
            });
        </script>
        ";
    }
}
?>
<script>
// Hàm thiết lập ID sản phẩm để khôi phục
function setRestoreProductId(id) {
    const restoreUrl = `?page=product-trash&restore_id=${id}`;
    document.getElementById('confirmRestoreProductButton').setAttribute('href', restoreUrl);
}

// Hàm thiết lập ID sản phẩm để xóa vĩnh viễn
function setDeleteProductId(id) {
    const deleteUrl = `?page=product-trash&delete_id=${id}`;
    document.getElementById('confirmPermanentDeleteProductButton').setAttribute('href', deleteUrl);
}
</script>
