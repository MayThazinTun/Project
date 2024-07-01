<?php

// create default sizes
$sizes = [
    ['size_id' => 1, 'size' => 'XXS'],
    ['size_id' => 2, 'size' => 'XS'],
    ['size_id' => 3, 'size' => 'S'],
    ['size_id' => 4, 'size' => 'M'],
    ['size_id' => 5, 'size' => 'L'],
    ['size_id' => 6, 'size' => 'XL'],
    ['size_id' => 7, 'size' => 'XXL'],
    ['size_id' => 8, 'size' => 'XXXL'],
];
// Create Custom Sizes
// function createSizes($mysqli, $sizes)
// {
//     foreach ($sizes as $size) {
//         $size_id = $size['size_id'];
//         $size = $size['size'];

//         $size_price = 0;

//         $sql = "INSERT INTO `sizes`(`size_id`, `size`, `size_price`) VALUES ('$size_id', '$size', '$size_price')";

//         $mysqli->query($sql);
//     }
// }
// $mysqli = new mysqli("localhost", "root", "", "shopping");
// createSizes($mysqli, $sizes);

function create_size($mysqli, $size, $size_price)
{
    $sql = "INSERT INTO `sizes`(`size`, `size_price`) VALUES ('$size', $size_price)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//get all sizes
function get_all_sizes($mysqli)
{
    $sql = "SELECT * FROM `sizes`";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return false;
}

//get sizes by id
function getSizeById($mysqli, $size_id)
{
    $sql = "SELECT * FROM `sizes` WHERE `size_id` = $size_id";
    $result = $mysqli->query($sql);
    return $result;
}

//update size by id
function updateSizeById($mysqli, $size_id, $size, $size_price)
{
    $sql = "UPDATE `sizes` SET `size` = '$size', `size_price` = $size_price WHERE `size_id` = $size_id";
    $mysqli->query($sql);
}

// update size by name
function updateSizeByName($mysqli, $size, $size_price)
{
    $sql = "UPDATE `sizes` SET `size_price` = $size_price WHERE `size` = '$size'";
    $mysqli->query($sql);
}

//delete size by id
function deleteSizeById($mysqli, $size_id)
{
    $sql = "DELETE FROM `sizes` WHERE `size_id` = $size_id";
    $mysqli->query($sql);
}

function get_total_sizes_count($mysqli) {
    $sql = "SELECT COUNT(*) as total FROM `sizes`";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

function get_all_sizes_pagination($mysqli, $limit, $offset) {
    $sql = "SELECT * FROM `sizes` LIMIT $limit OFFSET $offset";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}
