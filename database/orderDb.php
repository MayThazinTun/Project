<?php

//create orders
function create_order_product($mysqli, $user_id, $product_id, $item_id, $product_type, $invoice_id, $order_quantity, $shipping_address, $order_description)
{
    $sql = "INSERT INTO `orders`(`user_id`,`product_id`,`item_id`,`product_type`,`invoice_id`,`order_quantity`,`shipping_address`,`order_description`) VALUES ($user_id,$product_id,null,'$product_type',$invoice_id,$order_quantity,'$shipping_address','$order_description')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function create_order_item($mysqli, $user_id, $product_id, $item_id, $product_type, $invoice_id, $order_quantity, $shipping_address, $order_description)
{
    $sql = "INSERT INTO `orders`(`user_id`,`product_id`,`item_id`,`product_type`,`invoice_id`,`order_quantity`,`shipping_address`,`order_description`) VALUES ($user_id,null,$item_id,'$product_type',$invoice_id,$order_quantity,'$shipping_address','$order_description')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
//get all orders
function get_all_orders($mysqli)
{
    $sql = "SELECT * FROM `orders`";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

//get order by id
function get_order_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `orders` WHERE `id` = $id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_order_by_invoice_id($mysqli, $invoice_id)
{
    $sql = "SELECT * FROM `orders`   WHERE invoice_id = $invoice_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    }
    return false;
}

//update order by id
function update_order_by_id($mysqli, $id, $user_id, $products_id, $invoice_id)
{
    $sql = "UPDATE `orders` SET `user_id`=$user_id,`products_id`=$products_id,`invoice_id`=$invoice_id WHERE `id` = $id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// delete order by id
function delete_order_by_id($mysqli, $id)
{
    $sql = "DELETE FROM `orders` WHERE `id` = $id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
