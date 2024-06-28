<?php

//create products
function create_item($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $item_price,$item_quantity, $item_note)
{
    $sql = "INSERT INTO `products`(`category_id`,`type_id`,`color_id`,`size_id`,`sticker_id`,`item_price`,`item_quantity`,`product_images`,`item_note`) VALUES ('$category_id','$type_id','$color_id','$size_id','$sticker_id','$item_price','$item_quantity',null)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
function createProductAll($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $item_price, $item_quantity, $item_note)
{
    $sql = "INSERT INTO `products`(`category_id`,`type_id`,`color_id`,`size_id`,`sticker_id`,`item_price`,`item_quantity`,`product_images`,`item_note`) VALUES ('$category_id','$type_id','$color_id','$size_id','$sticker_id','$item_price','$item_quantity','$item_note')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}


// get all products
function getAll($mysqli)
{
    $sql = "SELECT items.*, categories.category_id FROM `products` 
    INNER JOIN categories ON products.category_id = categories.category_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    }
    return false;
}

function get_all_items($mysqli)
{
    $sql = "SELECT * FROM items
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

function get_all_items_paginated($mysqli, $limit, $offset, $search = '')
{
    $sql = "SELECT items.*, categories.category_name, types.type_price, colors.color_name, sizes.size, stickers.sticker_price 
            FROM `items` 
            LEFT JOIN `categories` ON items.category_id = categories.category_id 
            LEFT JOIN `types` ON items.type_id = types.type_id 
            LEFT JOIN `colors` ON items.color_id = colors.color_id 
            LEFT JOIN `sizes` ON items.size_id = sizes.size_id 
            LEFT JOIN `stickers` ON items.sticker_id = stickers.sticker_id
            WHERE 1";
    if (!empty($search)) {
        $search = $mysqli->real_escape_string($search);
        $sql .= " AND ( items.item_price LIKE '%$search%'
                      OR items.created_at LIKE '%$search%'
                      OR categories.category_name LIKE '%$search%'
                      OR types.type_price LIKE '%$search%'
                      OR colors.color_name LIKE '%$search%'
                      OR sizes.size LIKE '%$search%'
                      OR stickers.sticker_price LIKE '%$search%'
                      OR items.item_quantity LIKE '%$search%'
                      OR items.item_note LIKE '%$search%')";
    }

    $sql .= " ORDER BY items.created_at DESC LIMIT $limit OFFSET $offset";

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

function get_total_item_count($mysqli, $search = '')
{
    $sql = "SELECT COUNT(*) as count FROM `items` 
            LEFT JOIN `categories` ON items.category_id = categories.category_id 
            LEFT JOIN `types` ON items.type_id = types.type_id 
            LEFT JOIN `colors` ON items.color_id = colors.color_id 
            LEFT JOIN `sizes` ON items.size_id = sizes.size_id 
            LEFT JOIN `stickers` ON items.sticker_id = stickers.sticker_id 
            WHERE 1";

    if (!empty($search)) {
        $search = $mysqli->real_escape_string($search);
        $sql .= " AND (items.item_price LIKE '%$search%' 
                      OR items.created_at LIKE '%$search%'
                      OR categories.category_name LIKE '%$search%'
                      OR types.type_price LIKE '%$search%'
                      OR colors.color_name LIKE '%$search%'
                      OR sizes.size LIKE '%$search%'
                      OR stickers.sticker_price LIKE '%$search%'
                      OR items.item_quantity LIKE '%$search%'
                      OR items.item_note LIKE '%$search%')";
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
function get_item_by_id($mysqli, $item_id)
{
    $sql = "SELECT items.*, categories.category_name, types.type_price, colors.color_name, sizes.size, stickers.sticker_price 
            FROM `items` 
            LEFT JOIN `categories` ON items.category_id = categories.category_id 
            LEFT JOIN `types` ON items.type_id = types.type_id 
            LEFT JOIN `colors` ON items.color_id = colors.color_id 
            LEFT JOIN `sizes` ON items.size_id = sizes.size_id 
            LEFT JOIN `stickers` ON items.sticker_id = stickers.sticker_id
            WHERE items.item_id = ?";

    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }
    return null;
}

// get product by name
// function get_item_by_name($mysqli, $name)
// {
//     $sql = "SELECT * FROM `products` WHERE `product_name` = '$name'";
//     $result = $mysqli->query($sql);
//     if ($result->num_rows > 0) {
//         return $result->fetch_assoc();
//     }
//     return false;
// }
function get_item_by_category_id($mysqli, $category_id)
{
    $sql = "SELECT * FROM `items` WHERE `category_id` = $category_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    }
    return false;
}

// Update product with optional fields
// function update_item($mysqli, $item_id, $category_id, $type_id, $color_id, $size_id, $sticker_id, $item_price, $item_quantity, $item_note)
// {
//     $sql = "UPDATE `products` SET 
//             `category_id` = '$category_id',
//             `type_id` = NULL,
//             `color_id` = NULL,
//             `size_id` = NULL,
//             `sticker_id` = NULL,
//             `item_price` = '$item_price',
//             `item_quantity` = '$item_quantity',
//             `item_note` = NULL
//             WHERE `item_id` = '$item_id'";

//     if ($mysqli->query($sql)) {
//         return true;
//     }
//     return false;
// }

// Update product with all fields
function update_item_all($mysqli, $item_id, $category_id, $type_id, $color_id, $size_id, $sticker_id, $item_price, $item_quantity, $item_note)
{
    $sql = "UPDATE `items` SET 
            `category_id` = '$category_id',
            `type_id` = '$type_id',
            `color_id` = '$color_id',
            `size_id` = '$size_id',
            `sticker_id` = '$sticker_id',
            `item_price` = '$item_price',
            `item_quantity` = '$item_quantity',
            `item_note` = NULL
            WHERE `item_id` = '$item_id'";

    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// delete product by id
function delete_item_by_id($mysqli, $item_id)
{
    $sql = "DELETE FROM `items` WHERE `item_id` = '$item_id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
