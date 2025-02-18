<link href="asset/css/product.css" rel="stylesheet" />
<?php
$categoryId = $_GET['id'];
$sql = "SELECT p.product_name,p.slug,p.price,p.sale_price,p.is_on_sale,c.id,p.cat_id,p.image FROM product p INNER JOIN category c on p.cat_id = c.id WHERE p.cat_id = $categoryId OR c.parent=$categoryId";
$sql_cat_name = "SELECT category_name FROM category WHERE id = $categoryId";
$result_cat_name = $s->getOne($sql_cat_name);
$result = $s->getAll($sql);
?>

<h2 class='product-title'><?= $result_cat_name['category_name'] ?></h2>
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
                <button class="add-to-cart btn btn-primary">
                    <a href="<?= BASE_URL ?>page=addToCart&id=<?= $value['id'] ?>"
                        class="text-white text-decoration-none">Add to Cart</a>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>