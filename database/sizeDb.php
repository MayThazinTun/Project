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
function createSizes($mysqli, $sizes)
{
    foreach ($sizes as $size) {
        $size_id = $size['size_id'];
        $size = $size['size'];

        $size_price = 0;

        $sql = "INSERT INTO `sizes`(`size_id`, `size`, `size_price`) VALUES ('$size_id', '$size', '$size_price')";

        $mysqli->query($sql);
    }
}
// $mysqli = new mysqli("localhost", "root", "", "shopping");
// createSizes($mysqli, $sizes);

//get all sizes
function getSizes($mysqli)
{
    $sql = "SELECT * FROM `sizes`";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

//get sizes by id
function getSizeById($mysqli, $size_id)
{
    $sql = "SELECT * FROM `sizes` WHERE `size_id` = '$size_id'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

//update size by id
function updateSizeById($mysqli, $size_id, $size, $size_price)
{
    $sql = "UPDATE `sizes` SET `size` = '$size', `size_price` = '$size_price' WHERE `size_id` = '$size_id'";
    $mysqli->query($sql);
}

// update size by name
function updateSizeByName($mysqli, $size, $size_price)
{
    $sql = "UPDATE `sizes` SET `size_price` = '$size_price' WHERE `size` = '$size'";
    $mysqli->query($sql);
}

//delete size by id
function deleteSizeById($mysqli, $size_id)
{
    $sql = "DELETE FROM `sizes` WHERE `size_id` = '$size_id'";
    $mysqli->query($sql);
}
