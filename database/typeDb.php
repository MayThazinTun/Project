<?php

// create type
function create_type($mysqli, $type_id, $type_price, $type_name)
{
    $sql = "INSERT INTO `types`(`type_id`, `type_price`, `type_name`) VALUES ('$type_id','$type_price','$type_name')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// // create 10 types
// function create_10_types($mysqli)
// {
//     for ($i = 1; $i <= 10; $i++) {
//         $type_id = $i;
//         $type_price = $i * 10;
//         $type_name = "Type $i";
//         create_type($mysqli, $type_id, $type_price, $type_name);
//     }
//     return true;
// }
// $mysqli = new mysqli("localhost", "root", "", "shopping");
// create_10_types($mysqli);

//get all types
function get_all_types($mysqli)
{
    $sql = "SELECT * FROM `types`";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return false;
}

//get type by id
function get_type_by_id($mysqli, $type_id)
{
    $sql = "SELECT * FROM `types` WHERE `type_id`='$type_id'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

// update type by id
function update_type_by_id($mysqli, $type_id, $type_price, $type_name)
{
    $sql = "UPDATE `types` SET `type_price`='$type_price',`type_name`='$type_name' WHERE `type_id`='$type_id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// delete type by id
function delete_type_by_id($mysqli, $type_id)
{
    $sql = "DELETE FROM `types` WHERE `type_id`='$type_id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
