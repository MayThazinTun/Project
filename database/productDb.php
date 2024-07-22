<?php

//create products
function create_product($mysqli, $category_id, $product_name, $product_size, $product_color, $product_quantity, $product_price, $product_images, $product_description)
{
    $sql = "INSERT INTO `products`(`category_id`,`product_name`,`product_size`,`product_color`,`product_quantity`,`product_price`,`product_images`,`product_description`) 
    VALUES ($category_id,'$product_name','$product_size','$product_color',$product_quantity,$product_price,'$product_images','$product_description')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// function createProductAll($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $product_name, $product_price, $product_quantity, $product_images, $product_description)
// {
//     $sql = "INSERT INTO `products`(`category_id`,`type_id`,`color_id`,`size_id`,`sticker_id`,`product_name`,`product_price`,`product_quantity`,`product_images`,`product_description`) VALUES ('$category_id','$type_id','$color_id','$size_id','$sticker_id','$product_name','$product_price','$product_quantity','$product_images','$product_description')";
//     if ($mysqli->query($sql)) {
//         return true;
//     }
//     return false;
// }


// get all products
function getAll($mysqli)
{
    $sql = "SELECT products.*, categories.category_id FROM `products` 
    INNER JOIN categories ON products.category_id = categories.category_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    }
    return false;
}

function get_all_products($mysqli)
{
    $sql = "SELECT * FROM products
INNER JOIN categories ON products.category_id = categories.category_id";
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
    $sql = "SELECT products.*, categories.category_name 
            FROM `products` 
            LEFT JOIN `categories` ON products.category_id = categories.category_id 
            WHERE 1";
    if (!empty($search)) {
        $search = $mysqli->real_escape_string($search);
        $sql .= " AND (products.product_name LIKE '%$search%'
                      OR products.product_price LIKE '%$search%'
                      OR products.created_at LIKE '%$search%'
                      OR categories.category_name LIKE '%$search%'
                      OR products.product_quantity LIKE '%$search%'
                      OR products.product_description LIKE '%$search%')";
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
            LEFT JOIN `categories` ON products.category_id = categories.category_id
            WHERE 1";

    if (!empty($search)) {
        $search = $mysqli->real_escape_string($search);
        $sql .= " AND (products.product_name LIKE '%$search%' 
                      OR products.product_price LIKE '%$search%' 
                      OR products.created_at LIKE '%$search%'
                      OR categories.category_name LIKE '%$search%'
                      OR products.product_quantity LIKE '%$search%'
                      OR products.product_description LIKE '%$search%')";
    }

    $result = $mysqli->query($sql);

    if ($result === false) {
        error_log("Database Query Failed: " . $mysqli->error);
        return 0;
    }

    $row = $result->fetch_assoc();
    return $row['count'];
}

// get product by id
function get_product_by_id($mysqli, $product_id)
{
    $sql = "SELECT products.*, categories.category_name 
            FROM `products` 
            LEFT JOIN `categories` ON products.category_id = categories.category_id
            WHERE products.product_id = ?";

    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
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
    $sql = "SELECT products.product_id,categories.category_id,
    products.product_name, products.product_size,
    products.product_color, products.product_quantity, 
    products.product_price,products.product_images, 
    products.product_description FROM `products` INNER JOIN `categories` ON products.category_id = categories.category_id WHERE products.category_id = $category_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    }
    return false;
}

// Update product with optional fields
function update_product($mysqli, $product_id, $category_id, $product_name, $product_size, $product_color, $product_quantity, $product_price, $product_images, $product_description)
{
    $sql = "UPDATE `products` SET 
            `category_id` = '$category_id',
            `product_name` = '$product_name',
            `product_size` = '$product_size',
            `product_color` = '$product_color',
            `product_quantity` = $product_quantity,
            `product_price` = $product_price,
            `product_images` = '$product_images',
            `product_description` = '$product_description'
            WHERE `product_id` = $product_id";

    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// Update product with all fields
// function update_product_all($mysqli, $product_id, $category_id, $type_id, $color_id, $size_id, $sticker_id, $product_name, $product_price, $product_quantity, $product_images, $product_description)
// {
//     $sql = "UPDATE `products` SET 
//             `category_id` = '$category_id',
//             `type_id` = '$type_id',
//             `color_id` = '$color_id',
//             `size_id` = '$size_id',
//             `sticker_id` = '$sticker_id',
//             `product_name` = '$product_name',
//             `product_price` = '$product_price',
//             `product_quantity` = '$product_quantity',
//             `product_images` = '$product_images',
//             `product_description` = '$product_description'
//             WHERE `product_id` = '$product_id'";

//     if ($mysqli->query($sql)) {
//         return true;
//     }
//     return false;
// }

// delete product by id
function delete_product_by_id($mysqli, $product_id)
{
    $sql = "DELETE FROM `products` WHERE `product_id` = $product_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
