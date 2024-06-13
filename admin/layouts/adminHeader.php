<?php
require_once('../../database/index.php');
require_once('../baseUrl.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/products/index.php' ?>">Products</a></li>
                    <li class="list-group-item"><a href="<?php echo BASE_URL.'admin/' ?>">Logout</a></li>
                    <li class="list-group-item"><a href="#">Electronic Accessories</a></li>
                    <li class="list-group-item"><a href="#">TV & Home Appliances</a></li>
                    <li class="list-group-item"><a href="#">Women's Fashion</a></li>
                    <li class="list-group-item"><a href="#">Men's Fashion</a></li>
                    <li class="list-group-item"><a href="#">Groceries & Pets</a></li>
                    <li class="list-group-item"><a href="#">Home & Lifestyle</a></li>
                </ul>
            </div>
            <div class="right col-10">