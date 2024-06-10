<?php

//create products
function create_product($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $product_name, $product_price, $product_quantity)
{
    $sql = "INSERT INTO `products`(`category_id`,`type_id`,`color_id`,`size_id`,`sticker_id`,`product_name`,`product_price`,`product_quantity`) VALUES ('$category_id','$type_id','$color_id','$size_id','$sticker_id','$product_name','$product_price','$product_quantity')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// get all products
function get_all_products($mysqli)
{
    $sql = "SELECT * FROM `products`";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

// get product by id
function get_product_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

// get product by name
function get_product_by_name($mysqli, $name)
{
    $sql = "SELECT * FROM `products` WHERE `product_name` = '$name'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

// update product by id
function update_product_by_id($mysqli, $id, $category_id, $type_id, $color_id, $size_id, $sticker_id, $product_name, $product_price, $product_quantity)
{
    $sql = "UPDATE `products` SET `category_id`='$category_id',`type_id`='$type_id',`color_id`='$color_id',`size_id`='$size_id',`sticker_id`='$sticker_id',`product_name`='$product_name',`product_price`='$product_price',`product_quantity`='$product_quantity' WHERE `id` = '$id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// delete product by id
function delete_product_by_id($mysqli, $id)
{
    $sql = "DELETE FROM `products` WHERE `id` = '$id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
