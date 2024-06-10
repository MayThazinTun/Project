<?php

//create stickers
function create_sticker($mysqli, $sticker_id, $sticker_price)
{
    $sql = "INSERT INTO `stickers`(`sticker_id`, `sticker_price`) VALUES ('$sticker_id','$sticker_price')";
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
    $sql = "SELECT * FROM `stickers` WHERE `sticker_id` = '$sticker_id'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return false;
}

//update sticker by id
function update_sticker_by_id($mysqli, $sticker_id, $sticker_price)
{
    $sql = "UPDATE `stickers` SET `sticker_price` = '$sticker_price' WHERE `sticker_id` = '$sticker_id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// delete sticker by id
function delete_sticker_by_id($mysqli, $sticker_id)
{
    $sql = "DELETE FROM `stickers` WHERE `sticker_id` = '$sticker_id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//Example 5 stickers
for ($sticker_id = 1; $sticker_id <= 5; $sticker_id++) {

    $sticker_price = rand(1, 100);

    $mysqli = new mysqli("localhost", "root", "", "shopping");
    create_sticker($mysqli, $sticker_id, $sticker_price);
}
