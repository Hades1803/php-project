<?php
include('lib/file.php');
$userId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_FILES['image'];
    $pass = $_POST['pswd'];
    $a = array(
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['add'],
        'gender' => $_POST['gender'],
        'username' => $_POST['user'],
    );

    // Xử lý avatar nếu có upload
    if ($image['size'] != 0) {
        $a['avatar'] = $image['name'];
        $u = new Upload;
        $u->doUpload($image,"/NguyenAnhQuoc/asset/avatar/");
    }

    // Xử lý mật khẩu nếu có thay đổi
    if (!empty($pass)) {
        $a['password'] = sha1($pass);
    }

    // Cập nhật thông tin trong cơ sở dữ liệu
    $s->editRecord("user", $userId, $a);

    // Lấy thông tin mới từ cơ sở dữ liệu và cập nhật session
    $updatedUser = $s->getOne("SELECT * FROM user WHERE id = $userId");
    $_SESSION['user'] = $updatedUser;

    // Hiển thị thông báo SweetAlert sau khi cập nhật thành công
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Thông tin đã được cập nhật thành công!",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                // Chuyển hướng đến trang tài khoản sau khi nhấn OK
                window.location.href = "' . $_SERVER['PHP_SELF'] . '?page=account&id=' . $userId . '";
            }
        });
    </script>';
    exit();
}

// Lấy thông tin người dùng hiện tại từ cơ sở dữ liệu
$sql = "SELECT * FROM user WHERE id = $userId";
$result = $s->getOne($sql);
?>

<div class="row px-5">
    <div class="text-center mb-3">
        <div class="avatar-container">
            <img src="/NguyenAnhQuoc/asset/avatar/<?= $result['avatar'] ?>" alt="Avatar"
                class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
        </div>
    </div>
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item active"><a class="btn" href="">Cập nhật tài khoản</a></li>
            <li class="list-group-item"><a class="btn text-dark" href="">Quản lý đơn hàng</a></li>
            <li class="list-group-item"><a class="btn text-dark" href="">Blog</a></li>
        </ul>
    </div>

    <div class="col-md-9">
        <h2 class="text-success">Cập nhật tài khoản</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?page=account&id=<?= $userId ?>"
            method="post" enctype="multipart/form-data">

            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Họ tên<span class="text-danger">(*)</span></label>
                <input type="text" class="form-control" placeholder="Họ tên" name="name" value="<?= $result['name'] ?>">
            </div>

            <div class="mb-3 mt-3">
                <label for="gender" class="form-label">Giới tính</label><br>
                Nam: <input type="radio" class="form-check-input" name="gender" value="1" <?php if ($result['gender'] == 1)
                    echo "checked"; ?>>
                Nữ: <input type="radio" class="form-check-input" name="gender" value="0" <?php if ($result['gender'] == 0)
                    echo "checked"; ?>>
            </div>

            <div class="mb-3 mt-3">
                <label for="phone" class="form-label">Điện thoại</label>
                <input type="text" class="form-control" placeholder="Điện thoại" name="phone"
                    value="<?= $result['phone'] ?>">
            </div>

            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"
                    value="<?= $result['email'] ?>">
            </div>

            <div class="mb-3 mt-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" placeholder="Địa chỉ" name="add"
                    value="<?= $result['address'] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="fileInput" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="fileInput" name="image">
            </div>

            <div class="mb-3 mt-3">
                <label for="user" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" placeholder="Tên đăng nhập" name="user"
                    value="<?= $result['username'] ?>">
            </div>

            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</div>