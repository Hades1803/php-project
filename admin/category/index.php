<?php
// Lấy danh sách danh mục
$sql = "SELECT * FROM category WHERE trash = 0";
$result = $f->getAll($sql);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus-circle"></i> Thêm danh mục
            </button>

            <table class="table table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Trạng thái</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
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
                                    data-bs-target="#editCategoryModal"
                                    onclick="editCategory(<?= $value['id'] ?>, '<?= $value['category_name'] ?>', '<?= $value['slug'] ?>', <?= $value['parent'] ?>, <?= $value['status'] ?>)">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteCategoryModal" onclick="setDeleteId(<?= $value['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal Thêm danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Thêm danh mục mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="categoryName" name="category_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>

                    <div class="mb-3">
                        <label for="parentCategory" class="form-label">Danh mục cha</label>
                        <select class="form-select" id="parentCategory" name="parent_category_id">
                            <option value="0">Không có</option>
                            <?php
                            foreach ($result as $category) {
                                echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sửa danh mục -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Sửa danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="id" id="editCategoryId">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="editCategoryName" name="category_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editSlug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="editSlug" name="slug" required>
                    </div>

                    <div class="mb-3">
                        <label for="editParentCategory" class="form-label">Danh mục cha</label>
                        <select class="form-select" id="editParentCategory" name="parent_category_id">
                            <option value="0">Không có</option>
                            <?php
                            foreach ($result as $category) {
                                echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Trạng thái</label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="1">Hiện</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Xác nhận xóa danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa danh mục này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a id="confirmDeleteButton" href="#" class="btn btn-danger">Xóa</a>
            </div>
        </div>
    </div>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['id'])) {
    $categoryName = $_POST['category_name'];
    $slug = $_POST['slug'];
    $parentCategoryId = $_POST['parent_category_id'];

    // Kiểm tra tên và slug
    $checkName = $f->checkExist("category", "category_name", $categoryName);
    $checkSlug = $f->checkExist("category", "slug", $slug);

    if ($checkName !== 1 || $checkSlug !== 1) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Tên hoặc slug đã tồn tại.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>
        ";
    } else {
        // Thêm danh mục
        $categoryData = [
            'category_name' => $categoryName,
            'slug' => $slug,
            'parent' => $parentCategoryId
        ];
        $f->addRecord("category", $categoryData);

        // Thông báo thành công
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Danh mục đã được thêm thành công!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '" . $_SERVER['REQUEST_URI'] . "';
                    }
                });
            });
        </script>
        ";
    }
}

?>







<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $categoryName = $_POST['category_name'];
    $slug = $_POST['slug'];
    $parentCategoryId = $_POST['parent_category_id'];
    $status = $_POST['status'];

    // Lấy thông tin danh mục hiện tại từ cơ sở dữ liệu
    $sql = "SELECT * FROM category WHERE id = $id";
    $currentCategory = $f->getOne($sql);

    // Kiểm tra xem tên hoặc slug có thay đổi không
    $isNameChanged = $categoryName !== $currentCategory['category_name'];
    $isSlugChanged = $slug !== $currentCategory['slug'];

    if ($isNameChanged || $isSlugChanged) {
        // Nếu tên hoặc slug thay đổi, kiểm tra trùng lặp
        $checkName = $f->checkExist("category", "category_name", $categoryName);
        $checkSlug = $f->checkExist("category", "slug", $slug);

        if ($checkName !== 1 || $checkSlug !== 1) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Tên hoặc slug đã tồn tại.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            ";
            return; 
        }
    }

    // Cập nhật danh mục
    $categoryData = [
        'category_name' => $categoryName,
        'slug' => $slug,
        'parent' => $parentCategoryId,
        'status' => $status
    ];
    $f->editRecord("category", $id, $categoryData);

    // Thông báo thành công
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Thành công!',
                text: 'Danh mục đã được cập nhật thành công!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '" . $_SERVER['REQUEST_URI'] . "';
                }
            });
        });
    </script>
    ";
}


?>



<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kiểm tra xem danh mục có sản phẩm hay không
    $sql = "SELECT COUNT(*) as product_count FROM product WHERE cat_id = $id";
    $checkProducts = $f->getAll($sql);

    if ($checkProducts[0]['product_count'] > 0) {
        // Nếu có sản phẩm, không cho phép xóa
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Danh mục này có sản phẩm, không thể xóa!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                           window.location.href = 'http://localhost/NguyenAnhQuoc/admin/index.php?page=categories'; 
                        }
                    });
                });
            </script>
        ";
    } else {
        // Thay vì xóa, di chuyển vào trash
        $f->trashRecord("category", $id);

        // Thông báo thành công và chuyển hướng sang trang category-trash.php
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Danh mục đã được di chuyển vào thùng rác!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                           window.location.href = 'http://localhost/NguyenAnhQuoc/admin/index.php?page=category-trash'; 
                        }
                    });
                });
            </script>
        ";
    }
}


?>




<script>
    function editCategory(id, name, slug, parentId, status) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editSlug').value = slug;
        document.getElementById('editParentCategory').value = parentId;
        document.getElementById('editStatus').value = status; // Đặt giá trị trạng thái
    }

</script>

<script>

    function setDeleteId(id) {
        const deleteUrl = `?page=categories&id=${id}`;
        document.getElementById('confirmDeleteButton').setAttribute('href', deleteUrl);
    }


</script>


<script>
    function removeVietnameseTones(str) {
        return str
            .normalize('NFD') // Chuẩn hóa Unicode để tách dấu
            .replace(/[\u0300-\u036f]/g, '') // Loại bỏ dấu
            .replace(/đ/g, 'd') // Thay 'đ' bằng 'd'
            .replace(/Đ/g, 'D') // Thay 'Đ' bằng 'D'
            .toLowerCase();
    }

    document.getElementById('categoryName').addEventListener('input', function () {
        const slugInput = document.getElementById('slug');
        let slug = removeVietnameseTones(this.value)
            .trim()
            .replace(/[\s\-]+/g, '-') // Thay khoảng trắng và gạch ngang thừa bằng 1 gạch ngang
            .replace(/[^a-z0-9\-]/g, ''); // Loại bỏ ký tự không hợp lệ
        slugInput.value = slug;
    });
</script>