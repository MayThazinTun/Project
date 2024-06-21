<?php

// create type
function create_type($mysqli, $type_price, $type_images)
{
    $sql = "INSERT INTO `types`(`type_price`, `type_images`) VALUES ('$type_price','$type_images')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

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
function update_type_by_id($mysqli, $type_id, $type_price, $type_images)
{
    $sql = "UPDATE `types` SET `type_price`='$type_price',`type_images`='$type_images' WHERE `type_id`='$type_id'";
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



// Get types by Pagination
function get_all_types_pagination($mysqli, $limit, $offset)
{
    $sql = "SELECT * FROM `types` 
            ORDER BY `type_id` DESC
            LIMIT $limit OFFSET $offset";

    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function get_total_types_count($mysqli)
{
    $sql = "SELECT count(*) as total FROM `types`";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}