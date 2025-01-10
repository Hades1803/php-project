<?php
// Lấy danh sách danh mục trong thùng rác
$sql = "SELECT * FROM category WHERE trash = 1";
$result = $f->getAll($sql);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a href="index.php?page=categories" class="btn btn-primary mb-3">
                <i class="fas fa-arrow-left"></i> Quay lại danh mục
            </a>
            <table class="table table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Trạng thái</th>
                        <th>Khôi phục</th>
                        <th>Xóa vĩnh viễn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $value): ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['category_name'] ?></td>
                            <td><?= $value['status'] == 1 ? 'Hiện' : 'Ẩn' ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                   data-bs-target="#restoreCategoryModal"
                                   onclick="setRestoreCategoryId(<?= $value['id'] ?>)">
                                    <i class="fas fa-undo"></i> Khôi phục
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                   data-bs-target="#permanentDeleteModal"
                                   onclick="setDeleteCategoryId(<?= $value['id'] ?>)">
                                    <i class="fas fa-trash-alt"></i> Xóa vĩnh viễn
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Khôi phục danh mục -->
<div class="modal fade" id="restoreCategoryModal" tabindex="-1" aria-labelledby="restoreCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreCategoryModalLabel">Khôi phục danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn khôi phục danh mục này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a id="confirmRestoreButton" href="#" class="btn btn-success">Khôi phục</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xóa vĩnh viễn danh mục -->
<div class="modal fade" id="permanentDeleteModal" tabindex="-1" aria-labelledby="permanentDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permanentDeleteModalLabel">Xóa vĩnh viễn danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa vĩnh viễn danh mục này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a id="confirmPermanentDeleteButton" href="#" class="btn btn-danger">Xóa vĩnh viễn</a>
            </div>
        </div>
    </div>
</div>

<?php
// Xử lý khôi phục danh mục
if (isset($_GET['restore_id'])) {
    $id = $_GET['restore_id'];

    // Khôi phục danh mục từ thùng rác
    $f->restoreRecord("category", $id);

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Thành công!',
                text: 'Danh mục đã được khôi phục!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Đóng Swal trước khi reload trang
                    Swal.close();
                    window.location.href = 'http://localhost/NguyenAnhQuoc/admin/index.php?page=categories';
                }
            });
        });
    </script>
    ";
}

// Xử lý xóa vĩnh viễn danh mục
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Xóa vĩnh viễn danh mục
    $f->deleteRecord("category", $id);

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Thành công!',
                text: 'Danh mục đã được xóa vĩnh viễn!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Đóng Swal trước khi reload trang
                    Swal.close();
                    window.location.href = 'http://localhost/NguyenAnhQuoc/admin/index.php?page=categories';
                }
            });
        });
    </script>
    ";
}
?>


<script>
// Hàm thiết lập ID danh mục để khôi phục
function setRestoreCategoryId(id) {
    const restoreUrl = `?page=category-trash&restore_id=${id}`;
    document.getElementById('confirmRestoreButton').setAttribute('href', restoreUrl);
}

// Hàm thiết lập ID danh mục để xóa vĩnh viễn
function setDeleteCategoryId(id) {
    const deleteUrl = `?page=category-trash&delete_id=${id}`;
    document.getElementById('confirmPermanentDeleteButton').setAttribute('href', deleteUrl);
}
</script>
