<link href="asset/css/product-detail.css" rel="stylesheet" />
<?php
$slug = $_GET['slug'];
$sql = "SELECT * FROM `product` WHERE slug ='" . $slug . "'";
$result = $s->getOne($sql);
$update_view = "UPDATE `product` SET views = views + 1 WHERE slug ='" . $slug . "'";

$s->setQuery($update_view);
?>
<div class="container">
    <div class="product-detail">
        <div class="product-image">
            <img src="/NguyenAnhQuoc/asset/images/<?php echo $result['image']; ?>"
                alt="<?php echo $result['product_name']; ?>">
        </div>
        <div class="product-info">
            <h1 class="product-title"><?php echo $result['product_name']; ?></h1>
            <?php if ($result['is_on_sale'] == 1): ?>
                <p class="product-price" style="text-decoration: line-through;color:#ccc;">
                    <?= number_format($result['price'], 0, ',', '.') ?> VND
                </p>
                <p class="sale-price" style="color: #e63946;font-size:40px;font-weight:bold;">
                    <?= number_format($result['sale_price'], 0, ',', '.') ?> VND</p>
            <?php else: ?>
                <p class="product-price"><?= number_format($result['price'], 0, ',', '.') ?> VND</p>
            <?php endif; ?>

            <p class="free-shipping">Free shipping</p>
            <div class="product-options">
                <div class="sizes">
                    <span>M</span>
                    <span>L</span>
                    <span>XL</span>
                    <span>XXL</span>
                </div>
                <div class="colors">
                    <div class="blue active"></div>
                    <div class="red"></div>
                    <div class="yellow"></div>
                </div>
            </div>
            <div class="add-to-cart">
                <button class="add-to-cart btn btn-primary">
                    <a href="<?= BASE_URL ?>page=addToCart&id=<?= $result['id'] ?>"
                        class="text-white text-decoration-none">Add to Cart</a>
                </button>
                <div class="quantity">
                    <span>-</span>
                    <input type="text" value="1">
                    <span>+</span>
                </div>
            </div>
            <div class="tabs">
                <h3>Mô tả</h3>
                <p><?php echo $result['description']; ?></p>
            </div>
        </div>
    </div>
</div>