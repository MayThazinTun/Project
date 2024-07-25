<?php

// create stickers

function create_sticker($mysqli, $sticker_price, $sticker_images)
{
    $sql = "INSERT INTO `stickers`(`sticker_price`, `sticker_images`) VALUES ($sticker_price,'$sticker_images')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//get all stickers
function get_all_stickers($mysqli)
{
    $sql = "SELECT * FROM `stickers`";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return false;
}

//get sticker by id
function get_sticker_by_id($mysqli, $sticker_id)
{
    $sql = "SELECT * FROM `stickers` WHERE `sticker_id` = $sticker_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    }
    return false;
}
function get_sticker_by_sticker($mysqli, $sticker_images)
{
    $sql = "SELECT * FROM `stickers` WHERE `sticker_images` = '$sticker_images'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

//update sticker by id
function update_sticker_by_id($mysqli, $sticker_id, $sticker_price, $sticker_images)
{
    $sql = "UPDATE `stickers` SET `sticker_price` = $sticker_price,`sticker_images` = '$sticker_images' WHERE `sticker_id` = $sticker_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// delete sticker by id
function delete_sticker_by_id($mysqli, $sticker_id)
{
    try {
        $sql = "DELETE FROM `stickers` WHERE `sticker_id` = $sticker_id";
        if ($mysqli->query($sql)) {
            return true;
        } else {
            throw new Exception($mysqli->error);
        }
    } catch (Exception $e) {
        echo "Error deleting sticker: " . $e->getMessage();
        return false;
    }
}



// Get Stickers by Pagination
function get_all_stickers_pagination($mysqli, $limit, $offset)
{
    $sql = "SELECT * FROM `stickers` 
            ORDER BY `sticker_id` DESC
            LIMIT $limit OFFSET $offset";

    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function get_total_stickers_count($mysqli)
{
    $sql = "SELECT count(*) as total FROM `stickers`";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}
