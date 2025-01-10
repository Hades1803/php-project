<?php
// Lấy danh sách sản phẩm
$sql = "SELECT p.*, c.category_name FROM product p LEFT JOIN category c ON p.cat_id = c.id";
$result = $f->getAll($sql);
$sqlCat = "SELECT * FROM category";
$resultCat = $f->getAll($sqlCat);
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus-circle"></i> Thêm sản phẩm
            </button>

            <table class="table table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Giảm giá</th>
                        <th>Hình ảnh</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $value): ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['product_name'] ?></td>
                            <td><?= $value['category_name'] ?></td>
                            <td><?= number_format($value['price'], 0, ',', '.') ?> VND</td>
                            <td><?= number_format($value['sale_price'], 0, ',', '.') ?> VND</td>
                            <td><img src="<?= $value['image'] ?>" alt="Product Image" width="50"></td>
                            <!-- <td><img src="/NguyenAnhQuoc/asset/avatar/<?= $value['image'] ?>" alt="Product Image" width="50"></td> -->
                            <td>
                                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#editProductModal"
                                    onclick="editProduct(<?= $value['id'] ?>, '<?= $value['product_name'] ?>', '<?= $value['slug'] ?>', '<?= $value['cat_id'] ?>', '<?= $value['price'] ?>', '<?= $value['sale_price'] ?>', '<?= $value['image'] ?>')">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteProductModal" onclick="setDeleteProductId(<?= $value['id'] ?>)">
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


<!-- Modal Thêm sản phẩm -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="productName" name="product_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>

                    <div class="mb-3">
                        <label for="productImage" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="productImage" name="image" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Danh mục</label>
                        <select class="form-select" id="category" name="category_id">
                            <option value="0">Chọn danh mục</option>
                            <?php
                            foreach ($resultCat as $category) {
                                echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="salePrice" class="form-label">Giá giảm</label>
                        <input type="number" class="form-control" id="salePrice" name="sale_price">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="desc" name="desc"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="metaDesc" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="metaDesc" name="metadesc"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Sửa sản phẩm -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Sửa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editProductId">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="editProductName" name="product_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editSlug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="editSlug" name="slug" required>
                    </div>

                    <div class="mb-3">
                        <label for="editProductImage" class="form-label">Hình ảnh</label>
                        <input type="hidden" name="old_image" id="old_image" value=""> 
                        <img src="" alt="Product Image" id="editProductImagePreview" width="50"> <!-- Preview hình ảnh -->
                        <input type="file" class="form-control" id="editProductImage" name="image" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Danh mục</label>
                        <select class="form-select" id="editCategory" name="category_id">
                            <option value="0">Chọn danh mục</option>
                            <?php
                            foreach ($resultCat as $category) {
                                echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="editPrice" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="editSalePrice" class="form-label">Giá giảm</label>
                        <input type="number" class="form-control" id="editSalePrice" name="sale_price">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="desc" name="desc"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editMetaDesc" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="editMetaDesc" name="metadesc"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Xác nhận xóa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa sản phẩm này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a id="confirmDeleteButton" href="#" class="btn btn-danger">Xóa</a>
            </div>
        </div>
    </div>
</div>

<?php

// Bao gồm file Upload.php
include_once('../lib/file.php');
// Khởi tạo đối tượng Upload
$upload = new Upload();

// Xử lý thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['id'])) {
    $productName = $_POST['product_name'];
    $slug = $_POST['slug'];
    $catId = $_POST['category_id']; 
    $image = $_FILES['image']; 
    $price = $_POST['price'];
    $description = $_POST['desc'];
    $metadesc = $_POST['metadesc'];
    $sale_price = $_POST['sale_price'];

    // Kiểm tra tên sản phẩm
    $checkProduct = $f->checkExist("product", "product_name", $productName);
    if ($checkProduct !== 1) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Tên sản phẩm đã tồn tại.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>
        ";
    } else {
        $upload->doUpload($image,"NguyenAnhQuoc/asset/images");  // Chuyển file hình ảnh vào hàm doUpload

        // Nếu upload thành công, tiếp tục thêm sản phẩm
        $productData = [
            'product_name' => $productName,
            'slug' => $slug,
            'cat_id' => $catId,
            'image' => $image['name'],  // Lưu tên file hình ảnh
            'price' => $price,
            'description' => $description,
            'metadesc' => $metadesc,
            'sale_price' => $sale_price
        ];

        $f->addRecord("product", $productData);

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Sản phẩm đã được thêm thành công!',
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

// Xử lý cập nhật sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $productName = $_POST['product_name'];
    $catId = $_POST['category_id'];
    $price = $_POST['price'];
    $salePrice = $_POST['sale_price'];
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $_POST['old_image']; // Nếu có thay đổi hình ảnh

    // Xử lý upload ảnh
    if ($image && $image != $_POST['old_image']) {
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
    }

    // Cập nhật sản phẩm
    $productData = [
        'product_name' => $productName,
        'cat_id' => $catId,
        'price' => $price,
        'sale_price' => $salePrice,
        'image' => $image,
    ];

    $f->editRecord("product", $id, $productData);

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Thành công!',
                text: 'Sản phẩm đã được cập nhật thành công!',
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

    // Tiến hành xóa sản phẩm
    $f->deleteRecord("product", $id);

    // Thông báo thành công và tải lại trang
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Sản phẩm đã được xóa thành công!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'http://localhost/NguyenAnhQuoc/admin/index.php?page=products'; 
                    }
                });
            });
        </script>
    ";
}
?>


<script>
    function editProduct(id, name, slug, catId, price, salePrice, imageUrl) {
        document.getElementById('editProductId').value = id;
        document.getElementById('editProductName').value = name;
        document.getElementById('editSlug').value = slug;
        document.getElementById('editCategory').value = catId;  // Dùng catId cho danh mục
        document.getElementById('editPrice').value = price;  // Giá
        document.getElementById('editSalePrice').value = salePrice;  // Giá giảm
        document.getElementById('old_image').value = imageUrl;  // Lưu hình ảnh cũ
        document.getElementById('editProductImagePreview').src = imageUrl;  // Hiển thị ảnh cũ
    }

    function setDeleteProductId(id) {
        const deleteUrl = `?page=products&id=${id}`;
        document.getElementById('confirmDeleteButton').setAttribute('href', deleteUrl);
    }

</script>
