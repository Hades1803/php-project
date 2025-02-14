<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = $_POST["product_id"];
    $quantity = intval($_POST["quantity"]);

    // Kiểm tra giỏ hàng tồn tại không
    if (isset($_SESSION["cart"]) && isset($_SESSION["amount"])) {
        $index = array_search($productId, $_SESSION["cart"]); // Tìm vị trí sản phẩm

        if ($index !== false) {
            $_SESSION["amount"][$index] = $quantity; // Cập nhật số lượng
            echo json_encode(["status" => "success", "message" => "Cart updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Product not found"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Cart is empty"]);
    }
}
?>
