<link href="asset/css/product.css" rel="stylesheet" />

<?php
$product_name = $_GET['product_name'];
$sql = "SELECT * FROM `product` WHERE product_name LIKE '%$product_name%'";
$result = $s->getAll($sql);
?>

<h2 class='product-title'>Sản phẩm theo tìm kiếm</h2>
<div class='product-list'>
    <?php foreach ($result as $value): ?>
        <div class="product-item">
            <div class="product-img">
                <img src="/NguyenAnhQuoc/asset/images/<?= $value["image"] ?>">
            </div>
            <div class="product-name">
                <h3><?= $value["product_name"] ?></h3>
            </div>
            <div class="price">
                <?php if ($value["is_on_sale"] == 1): ?>
                    <span class="default-price"
                        style="text-decoration: line-through;"><?= number_format($value['price'], 0, ',', '.') ?> VNĐ</span>
                    <span class="sale-price"><?= number_format($value['sale_price'], 0, ',', '.') ?> VNĐ</span>
                <?php else: ?>
                    <span class="default-price"><?= number_format($value['price'], 0, ',', '.') ?> VNĐ</span>
                <?php endif; ?>
            </div>
            <div class="button-action">
                <button class="view-more">
                    <a href="<?= BASE_URL ?>page=detail&slug=<?= $value["slug"] ?>">Chi Tiết</a>
                </button>
                <button class="add-to-cart">
                    Thêm vào giỏ hàng
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>