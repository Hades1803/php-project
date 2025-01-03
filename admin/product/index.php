<?php
// Lấy danh sách sản phẩm
$sql = "SELECT * FROM product";
$result = $f->getAll($sql);
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
                        <th>Giá</th>
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
                            <td><?= number_format($value['price'], 0, ',', '.') ?> VND</td>
                            <td>
                                <!-- Display product image -->
                                <img src="<?= $value['image'] ?>" alt="<?= $value['product_name'] ?>" style="width: 100px; height: auto;">
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#editProductModal"
                                    onclick="editProduct(<?= $value['id'] ?>, '<?= $value['product_name'] ?>', <?= $value['price'] ?>)">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteProductModal" onclick="setDeleteId(<?= $value['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
    </div>
</div>

