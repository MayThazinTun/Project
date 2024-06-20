<?php

//create products
function create_product($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $product_name, $product_price, $product_quantity)
{
    $sql = "INSERT INTO `products`(`category_id`,`type_id`,`color_id`,`size_id`,`sticker_id`,`product_name`,`product_price`,`product_quantity`) VALUES ('$category_id',null,null,null,null,'$product_name','$product_price','$product_quantity')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
function createProductAll($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $product_name, $product_price, $product_quantity)
{
    $sql = "INSERT INTO `products`(`category_id`,`type_id`,`color_id`,`size_id`,`sticker_id`,`product_name`,`product_price`,`product_quantity`) VALUES ('$category_id','$type_id','$color_id','$size_id','$sticker_id','$product_name','$product_price','$product_quantity')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}


// get all products
function getAll($mysqli)
{
    $sql = "SELECT * FROM `products`";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

function get_all_products($mysqli)
{
    $sql = "SELECT * FROM products
INNER JOIN categories ON products.category_id = categories.category_id
INNER JOIN types ON products.type_id = types.type_id
INNER JOIN colors ON products.color_id = colors.color_id
INNER JOIN sizes ON products.size_id = sizes.size_id
INNER JOIN stickers ON products.sticker_id = stickers.sticker_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}
//////////////////////////////////
//////////////////////////////////

function get_all_products_paginated($mysqli, $limit, $offset, $search = '')
{
    $sql = "SELECT products.*, categories.category_name, types.type_name, colors.color_name, sizes.size, stickers.sticker_price 
            FROM `products` 
            INNER JOIN `categories` ON products.category_id = categories.category_id 
            INNER JOIN `types` ON products.type_id = types.type_id 
            INNER JOIN `colors` ON products.color_id = colors.color_id 
            INNER JOIN `sizes` ON products.size_id = sizes.size_id 
            INNER JOIN `stickers` ON products.sticker_id = stickers.sticker_id
            WHERE 1";
    if (!empty($search)) {
        $search = $mysqli->real_escape_string($search);
        $sql .= " AND (products.product_name LIKE '%$search%'
                      OR products.product_price LIKE '%$search%'
                      OR products.created_at LIKE '%$search%'
                      OR categories.category_name LIKE '%$search%'
                      OR types.type_name LIKE '%$search%'
                      OR colors.color_name LIKE '%$search%'
                      OR sizes.size LIKE '%$search%'
                      OR stickers.sticker_price LIKE '%$search%'
                      OR products.product_quantity LIKE '%$search%')";
    }

    $sql .= " ORDER BY products.created_at DESC LIMIT $limit OFFSET $offset";

    $result = $mysqli->query($sql);

    if ($result === false) {
        error_log("Database Query Failed: " . $mysqli->error);
        return [];
    }

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function get_total_product_count($mysqli, $search = '')
{
    $sql = "SELECT COUNT(*) as count FROM `products` 
            INNER JOIN `categories` ON products.category_id = categories.category_id 
            INNER JOIN `types` ON products.type_id = types.type_id 
            INNER JOIN `colors` ON products.color_id = colors.color_id 
            INNER JOIN `sizes` ON products.size_id = sizes.size_id 
            INNER JOIN `stickers` ON products.sticker_id = stickers.sticker_id 
            WHERE 1";

    if (!empty($search)) {
        $search = $mysqli->real_escape_string($search);
        $sql .= " AND (products.product_name LIKE '%$search%' 
                      OR products.product_price LIKE '%$search%' 
                      OR products.created_at LIKE '%$search%'
                      OR categories.category_name LIKE '%$search%'
                      OR types.type_name LIKE '%$search%'
                      OR colors.color_name LIKE '%$search%'
                      OR sizes.size LIKE '%$search%'
                      OR stickers.sticker_price LIKE '%$search%'
                      OR products.product_quantity LIKE '%$search%')";
    }

    $result = $mysqli->query($sql);

    if ($result === false) {
        error_log("Database Query Failed: " . $mysqli->error);
        return 0;
    }

    $row = $result->fetch_assoc();
    return $row['count'];
}

//////////////////////////////////
//////////////////////////////////




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
function get_product_by_category_id($mysqli, $category_id)
{
    $sql = "SELECT * FROM `products` WHERE `category_id` = $category_id";
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
