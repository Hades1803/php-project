<link href="asset/css/product.css" rel="stylesheet" />
<?php

$sql = "SELECT * FROM `product` WHERE status = 1 AND trash = 0";
$result = $s->getAll($sql);
echo "<h2 class='product-title'>Trang Sản Phẩm</h2>";
echo "<div class='product-list'>";
foreach ($result as $value):
    ?>
    <div class="product-item">
        <div class="product-img">
            <img src="<?= $value["image"] ?>">
        </div>
        <div class="product-name">
            <h3><?= $value["product_name"] ?></h3>
        </div>
        <div class="price">
            <?php if ($value["is_on_sale"] == 1): ?>
                <span class="default-price" style="text-decoration: line-through;"><?= number_format($value['price'], 0, ',', '.') ?> VNĐ</span>
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
                    <a href="<?= BASE_URL ?>page=addToCart&id=<?= $value['id'] ?>">Add to
                            Cart</a>
                </button>
        </div>
    </div>
    <?php
endforeach;
echo "</div>";
?>
