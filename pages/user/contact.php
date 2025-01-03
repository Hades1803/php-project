<form action="/action_page.php">
  <p class="h2 text-success text-uppercase">Điền thông tin liên hệ</p>
  <div class="mb-3 mt-3">
    <label for="id" class="form-label">Mã Khách Hàng :</label>
    <input type="text" class="form-control" id="id" placeholder="Mã Khách Hàng" name="id">
  </div>
  <div class="mb-3">
    <label for="name" class="form-label">Họ và tên :</label>
    <input type="text" class="form-control" id="name" placeholder="Họ và tên" name="name">
  </div>
  <div class="mb-3 mt-3">
    <label for="address" class="form-label">Địa chỉ :</label>
    <input type="text" class="form-control" id="address" placeholder="Địa chỉ" name="address">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email:</label>
    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
  </div>
  <label for="comment">Nội dung liên hệ:</label>
    <textarea class="form-control" rows="5" id="comment" name="message"></textarea>
  <button type="submit" class="btn btn-success mt-2 rounded">Gửi</button>
</form>