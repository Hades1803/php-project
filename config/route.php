<?php 
    $route = [
        ''=>'pages/home.php',
        'contact'=>'pages/user/contact.php',
        'registration'=>'pages/user/registration.php',
        'products'=>'pages/product/product.php',
        'detail'=>'pages/product/productDetail.php',
        'search'=>'pages/product/search.php',
        'catProduct'=>'pages/product/catProduct.php',
        'login'=>'pages/user/login.php',
        'doLogin'=>'pages/user/doLogin.php',
        'logout'=>'pages/user/logout.php',
        'account'=> 'pages/user/account.php',
        'addToCart'=> 'cart/addToCart.php',
        'cart'=> 'cart/cart.php',
    ];

    $admin_route = [
        ''=> 'home.php',
        'categories' => 'category/index.php',
        'products' => 'product/index.php',
    ];    
?>