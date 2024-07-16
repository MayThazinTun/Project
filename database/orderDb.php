<?php

//create orders
function create_order($mysqli, $user_id, $products_id,$invoice_id,$shipping_address,$order_description)
{
    $sql = "INSERT INTO `orders`(`user_id`,`products_id`,`invoice_id`,`shipping_address`,`order_description`) VALUES ($user_id,$products_id,$invoice_id,'$shipping_address','$order_description')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function create_order_without_description($mysqli, $user_id, $products_id,$invoice_id,$shipping_address,$order_description)
{
    $sql = "INSERT INTO `orders`(`user_id`,`products_id`,`invoice_id`,`shipping_address`,`order_description`) VALUES ($user_id,$products_id,$invoice_id,'$shipping_address',null)";
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

//update order by id
function update_order_by_id($mysqli, $id, $user_id, $products_id,$invoice_id)
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
