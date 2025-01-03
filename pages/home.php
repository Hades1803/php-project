<link href="asset/css/home.css" rel="stylesheet"/>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Sofia&display=swap" rel="stylesheet">

<?php

    $sql = "SELECT * FROM `product` ORDER BY created_at DESC LIMIT 4";
    $result = $s->getAll($sql); 
?>

<h2 class="product-title">Sản phẩm mới</h2>
<div class="product-list">
    <?php foreach ($result as $product): ?>
    <div class="product-item">
        <div class="product-img">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
        </div>
        <div class="product-name">
            <h3><?= htmlspecialchars($product['product_name']) ?></h3>
        </div>
        <div class="price">
            <span><?= number_format($product['price'], 0, ',', '.') ?> VND</span>
        </div>
        <div class="button-action">
            <button class="view-more">
            <a href="<?= BASE_URL?>page=detail&slug=<?= $product['slug']?>">Chi Tiet</a>
            </button>
            <button class="add-to-cart">Thêm vào giỏ hàng</button>
        </div>
    </div>
    <?php endforeach; ?>
</div>




<?php

$query_views_product = "SELECT * FROM `product` ORDER BY views DESC LIMIT 4";
$views_product = $s->getAll($query_views_product); 
?>


<h2 class="product-title mt-4">Sản Phẩm Được Xem Nhiều Nhất</h2>
<div class="product-list">
    <?php foreach ($views_product as $views): ?>
    <div class="product-item">
        <div class="product-img">
            <img src="<?= htmlspecialchars($views['image']) ?>" alt="<?= htmlspecialchars($views['product_name']) ?>">
        </div>
        <div class="product-name">
            <h3><?= htmlspecialchars($views['product_name']) ?></h3>
        </div>
        <div class="price">
            <span><?= number_format($views['price'], 0, ',', '.') ?> VND</span>
        </div>
        <div class="button-action">
            <button class="view-more">
            <a href="<?= BASE_URL?>page=detail&slug=<?= $views['slug']?>">Chi Tiet</a>
            </button>
            <button class="add-to-cart">Thêm vào giỏ hàng</button>
        </div>
    </div>
    <?php endforeach; ?>
</div>




<?php

$query_sales_product = "SELECT * FROM `product` WHERE is_on_sale = 1 LIMIT 4";
$sales_product = $s->getAll($query_sales_product); 
?>



<h2 class="product-title mt-4">Sản Phẩm Đang Khuyến Mãi</h2>
<div class="product-list">
    <?php foreach ($sales_product as $sales): ?>
    <div class="product-item">
        <div class="product-img">
            <img src="<?= htmlspecialchars($sales['image']) ?>" alt="<?= htmlspecialchars($sales['product_name']) ?>">
        </div>
        <div class="product-name">
            <h3><?= htmlspecialchars($sales['product_name']) ?></h3>
        </div>
        <div class="price">
            
            <?php if ($sales["is_on_sale"] == 1): ?>
                <span class="default-price" style="text-decoration: line-through;"><?= number_format($sales['price'], 0, ',', '.') ?> VNĐ</span>
                <span class="sale-price"><?= $sales["sale_price"] ?> VNĐ</span>
            <?php else: ?>
                <span class="default-price"><?= $sales["price"] ?> VNĐ</span>
            <?php endif; ?>
        </div>
        <div class="button-action">
            <button class="view-more">
            <a href="<?= BASE_URL?>page=detail&slug=<?= $sales['slug']?>">Chi Tiet</a>
            </button>
            <button class="add-to-cart">Thêm vào giỏ hàng</button>
        </div>
    </div>
    <?php endforeach; ?>
</div>