<?php
require_once('../../database/index.php');
require_once('../../baseUrl.php');

$admin = null;
if (isset($_COOKIE['admin'])) {
    $admin = json_decode($_COOKIE['admin'], true);
}
if(!$admin){
    header("location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../../user/assets/fontawesome/css/fontawesome.css" rel="stylesheet" />
    <link href="../../user/assets/fontawesome/css/brands.css" rel="stylesheet" />
    <link href="../../user/assets/fontawesome/css/solid.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <style>
        .left {
            height: 100%;
            position: absolute;
            bottom: 0px;
            background-color: #e9ecef;

        }

        .right {
            height: 100%;
            position: absolute;
            background-color: #f8f9fa;
            bottom: 0px;
            left: 213px;
        }

        a {
            text-decoration: none;
        }

        .admin_text {
            font-size: 32px;
            font-weight: bold;
        }
    </style>
</head>


<body>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="left col-2">
                <span class="admin_text">Admin</span>
                <ul class="list-group">
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/users/index.php' ?>">User Info</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/category/index.php' ?>">Categories</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/product/index.php' ?>">Products</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/types/index.php' ?>">Types</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/colors/index.php' ?>">Colors</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/sizes/index.php' ?>">Sizes</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/stickers/index.php' ?>">Sticker</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/item/index.php' ?>">Customized List</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/orders/index.php' ?>">Orders</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/invoices/index.php' ?>">Invoices</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/logout.php' ?>">Logout</a></li>
                </ul>
            </div>
            <div class="right col-10">