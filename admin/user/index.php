<?php
// Lấy danh sách người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM user";
$result = $f->getAll($sql);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Bảng hiển thị danh sách người dùng -->
            <h3 class="mb-4">Danh sách người dùng</h3>
            <table class="table table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($result)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Không có dữ liệu người dùng nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($result as $value): ?>
                            <tr>
                                <td><?= htmlspecialchars($value['id']) ?></td>
                                <td><?= htmlspecialchars($value['username']) ?></td>
                                <td><?= htmlspecialchars($value['name']) ?></td>
                                <td><?= htmlspecialchars($value['email']) ?></td>
                                <td><?= htmlspecialchars($value['address']) ?></td>
                                <td><?= htmlspecialchars($value['phone']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
