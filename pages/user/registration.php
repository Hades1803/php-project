<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $addErr = $phoneErr = $userErr = $passErr = $birthErr = "";
$name = $email = $gender = $add = $phone = $username = $pass = $birth = "";
$flag = 1;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  if (empty($_POST["name"])) {
    $nameErr = "Họ tên không được để trống.";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[\p{L}\s'-]+$/u", $name)) {
      $nameErr = "Chỉ cho phép các chữ cái, dấu cách, dấu gạch nối và dấu nháy đơn";
      $flag = 0;
    }
  }

  //gender
  if ($_POST["gender"] == "") {
    $genderErr = "Vui lòng chọn giới tính.";
    $flag = 0;
  } else {
    $gender = test_input($_POST["gender"]);
  }

  //email
  if (empty($_POST["email"])) {
    $emailErr = "Email không được để trống.";
    $flag = 0;
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      $flag = 0;
    }
  }

  //birthday
  if (empty($_POST["birth"])) {
    $birthErr = "Ngày sinh không được để trống.";
    $flag = 0;
  } else {
    $birth = test_input($_POST["birth"]);
  }

  //phone
  if (empty($_POST["phone"])) {
    $phoneErr = "Số điện thoại không được để trống.";
    $flag = 0;
  } else {
    $phone = test_input($_POST["phone"]);
    // Kiểm tra xem số điện thoại có đúng 10 chữ số không
    if (!preg_match("/^\d{10}$/", $phone)) {
      $phoneErr = "Số điện thoại phải gồm đúng 10 chữ số.";
      $flag = 0; // Nếu không đúng, đặt flag về 0
    }
  }

  //address
  if (empty($_POST["address"])) {
    $addErr = "Địa chỉ không được để trống.";
    $flag = 0;
  } else {
    $add = test_input($_POST["address"]);
  }

  //username
  if (empty($_POST["userName"])) {
    $userErr = "Tên đăng nhập không được để trống.";
    $flag = 0;
  } else {
    $username = test_input($_POST["userName"]);
  }

  //password
  if (empty($_POST["pswd"])) {
    $passErr = "Mật khẩu không được để trống.";
    $flag = 0;
  } else {
    $pass = sha1(test_input($_POST["pswd"]));
  }

  if ($flag == 1) {
    // Kiểm tra xem username đã tồn tại hay chưa
    $checkUser = "SELECT id FROM user WHERE username = '" . $username . "'";
    $existingUser = $s->getOne($checkUser);

    if ($existingUser) {
      $userErr = "Tên đăng nhập đã tồn tại! Vui lòng chọn tên khác.";
      $flag = 0;
    }

    // Kiểm tra xem email đã tồn tại hay chưa
    $checkEmail = "SELECT id FROM user WHERE email = '" . $email . "'";
    $existingEmail = $s->getOne($checkEmail);

    if ($existingEmail) {
      $emailErr = "Email này đã được sử dụng! Vui lòng chọn email khác.";
      $flag = 0;
    }

    // Kiểm tra xem số điện thoại đã tồn tại hay chưa
    $checkPhone = "SELECT id FROM user WHERE phone = '" . $phone . "'";
    $existingPhone = $s->getOne($checkPhone);

    if ($existingPhone) {
      $phoneErr = "Số điện thoại này đã được sử dụng! Vui lòng chọn số khác.";
      $flag = 0;
    }

    if ($flag == 1) {
      $i = "temp.png";
      if ($_FILES['image']['size'] == 0) {
        echo $_FILES['image']['error'];
      } else {
        require("lib/file.php");
        $file = $_FILES['image'];
        $i = $file['name'];
        $u = new Upload();
        $u->doUpload($file);
      }
      $user = array(
        'username' => $_POST['userName'],
        'password' => sha1($_POST['pswd']),
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'gender' => $_POST['gender'],
        'birthday' => $_POST['birth'],
        'avatar' => $i,
      );
      $s->addRecord("user", $user);
      // Đặt lại các biến về giá trị mặc định
      $name = $email = $gender = $add = $phone = $username = $pass = $birth = "";
      $nameErr = $emailErr = $genderErr = $addErr = $phoneErr = $userErr = $passErr = $birthErr = "";
      echo '<script>
        alert("Đăng ký thành công!");
        window.location.href = "index.php";
        </script>';
      exit();
    }
  }
}
?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=registration" method="POST"
  enctype="multipart/form-data">
  <p class="h2 text-success text-center text-uppercase">Đăng Kí Thành Viên</p>
  <div class="mb-3">
    <label for="name" class="form-label fw-bold">Họ và tên :</label>
    <input type="text" class="form-control" id="name" placeholder="Họ và tên" name="name" value="<?= $name ?>">
    <span class="text-danger"><?= $nameErr ?></span>
  </div>
  <div class="mb-3">
    <?php
    if (isset($gender) && $gender == 1) {
      echo "    <label for='' class='form-label fw-bold'>Giới tính :</label>
    <div class='d-flex'>
      <div class=''>
        <label class='form-check-label' for='flexRadioDefault1'>
          Nam :
        </label>
        <input class='form-check-input' type='radio' name='gender' value='1' id='flexRadioDefault1' checked>
      </div>
      <div class='mx-2'>
        <label class='form-check-label ' for='flexRadioDefault2'>
          Nữ :
        </label>
        <input class='form-check-input' type='radio' name='gender' value='0' id='flexRadioDefault2' >
      </div>
    </div>";
    } else {
      echo "    <label for='' class='form-label fw-bold'>Giới tính :</label>
    <div class='d-flex'>
      <div class=''>
        <label class='form-check-label' for='flexRadioDefault1'>
          Nam :
        </label>
        <input class='form-check-input' type='radio' name='gender' value='1' id='flexRadioDefault1'>
      </div>
      <div class='mx-2'>
        <label class='form-check-label ' for='flexRadioDefault2'>
          Nữ :
        </label>
        <input class='form-check-input' type='radio' name='gender' value='0' id='flexRadioDefault2' checked>
      </div>
    </div>";
    }
    ?>
    <span><?= $genderErr ?></span>
  </div>
  <div class="mb-3">
    <label for="date" class="form-label fw-bold">Ngày sinh :</label>
    <input type="date" class="form-control" id="date" placeholder="Ngày sinh" name="birth" value="<?= $birth ?>">
    <span class="text-danger"><?= $birthErr ?></span>
  </div>
  <div class="mb-3">
    <label for="number" class="form-label fw-bold">Số điện thoại :</label>
    <input type="text" class="form-control" id="number" placeholder="Số điện thoại" name="phone" value="<?= $phone ?>">
    <span class="text-danger"><?= $phoneErr ?></span>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label fw-bold">Email:</label>
    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?= $email ?>">
    <span class="text-danger"><?= $emailErr ?></span>
  </div>
  <div class="mb-3">
    <label for="address" class="form-label fw-bold">Địa chỉ:</label>
    <input type="text" class="form-control" id="address" placeholder="Địa chỉ" name="address" value="<?= $add ?>">
    <span class="text-danger"><?= $addErr ?></span>
  </div>
  <div class="mb-3">
    <label for="image" class="form-label fw-bold">Image:</label>
    <input type="file" class="form-control" id="image" placeholder="Hinh anh" name="image">
  </div>

  <div class="mb-3">
    <label for="userName" class="form-label fw-bold">Tên đăng nhập:</label>
    <input type="text" class="form-control" id="userName" placeholder="Tên đăng nhập" name="userName"
      value="<?= $username ?>">
    <span class="text-danger"><?= $userErr ?></span>
  </div>
  <div class="mb-3">
    <label for="pswd" class="form-label fw-bold">Mật khẩu:</label>
    <input type="password" class="form-control" id="pswd" placeholder="Mật khẩu" name="pswd" value="<?= $pass ?>">
    <span class="text-danger"><?= $passErr ?></span>
  </div>
  <button type="submit" class="btn btn-success mt-2 rounded">Đăng Kí</button>
</form>