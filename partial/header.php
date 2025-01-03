<!DOCTYPE html>
<html>

<head>
	<title>adidas Vietnam Online - Shop Sports &amp; Originals | adidas VN</title>
	<link rel="icon" href="asset/images/logoAdidas.png" type="image/png">
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
		integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"
		integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"
		integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link href="asset/css/style.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');
	</style>

</head>

<body>
	<div class="container-fluid border-warning">
		<div class="row bg-white">
			<div class="col-md-4">
				<div class="logo py-2"><img class="mx-5" src="asset/images/logoAdidas.png" /></div>
			</div>
			<div class="col-md-4 pt-3">
				<form action="<?= BASE_URL ?>page=search&">
					<div class="input-group">
						<input type="hidden" name="page" value="search">
						<input type="text" class="form-control" placeholder="Search products" name="product_name">
						<input type="submit" class="btn btn-success" />
					</div>
				</form>
			</div>

			<div class="col-md-4 text-end pt-3">
				<?php
				if (!isset($_SESSION['user'])) {
					echo "<a href='' class='btn border'>
    <i class='fas fa-shopping-cart text-success'></i>
    <span class='badge text-black'></span></a>";
				} else {
					// Use a specific key from the array
					$username = is_array($_SESSION['user']) ? $_SESSION['user']['username'] : $_SESSION['user'];
					echo "<a href='" . BASE_URL . "page=account&id=" . $_SESSION['userId'] . "' class='btn border'>
    <i class='fas fa-shopping-cart text-success'></i>
    <span class='badge text-black'>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</span></a>";
				}
				?>



				<a href='' class="btn border">
					<i class="fas fa-heart text-success"></i>
					<span class="badge text-black">1</span>
				</a>
				<a href="<?= BASE_URL ?>page=cart" class="btn border">
					<i class="fas fa-shopping-cart text-success"></i>
					<span
						class="badge text-black"><?= isset($_SESSION['cart']) ? $_SESSION['number_of_item'] : 0 ?></span>
				</a>
			</div>
		</div>
		<div class="row header">

			<div class="col-md-12">
				<ul>
					<li class="active"><a href="<?= BASE_URL ?>">Trang chủ</a></li>
					<li><a href="<?= BASE_URL ?>page=products">Shop</a>
						<ul class="">
							<?php
							$sql = "SELECT * FROM category WHERE status = 1 AND trash = 0 AND parent = 0";
							$result = $s->getAll($sql);
							foreach ($result as $categoties):
								?>
								<li>
									<a
										href="<?= BASE_URL ?>page=catProduct&id=<?= $categoties['id'] ?>"><?= $categoties['category_name'] ?></a>
									<ul class="child" style="display:none;">
										<?php
										$sql_child = "SELECT * FROM category WHERE status = 1 AND trash = 0 AND parent = " . $categoties['id'];
										$result_child = $s->getAll($sql_child);
										foreach ($result_child as $child): ?>
											<li><a
													href="<?= BASE_URL ?>page=catProduct&id=<?= $child['id'] ?>"><?= $child['category_name'] ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
								</li>
								<?php
							endforeach;
							?>
						</ul>
					</li>
					<li><a href="">Blog</a></li>
					<li><a href="<?= BASE_URL ?>page=contact">Liên hệ</a></li>
					<li><a href="<?= BASE_URL ?>page=registration">Đăng ký</a></li>
					<?php
					// Kiểm tra nếu người dùng đã đăng nhập
					if (isset($_SESSION['user'])) {
						// Hiển thị nút Đăng xuất
						echo "<li><a href='" . BASE_URL . "page=logout'>Đăng xuất</a></li>";
					} else {
						echo "<li><a href='" . BASE_URL . "page=login'>Đăng nhập</a></li>";
					}
					?>

					<li><a href="">Tài khoản</a></li>
				</ul>
			</div>
		</div>
		<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
			<div class="carousel-indicators">
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
					aria-current="true" aria-label="Slide 1"></button>
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
					aria-label="Slide 2"></button>
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
					aria-label="Slide 3"></button>
			</div>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img src="asset/images/banner1.png" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item">
					<img src="asset/images/banner2.png" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item">
					<img src="asset/images/banner3.png" class="d-block w-100" alt="...">
				</div>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
				data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
				data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>