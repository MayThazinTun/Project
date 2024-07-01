<?php

$colors =
    [
        [
            'color_id' => 1,
            'color_name' => 'red'
        ],
        [
            'color_id' => 2,
            'color_name' => 'blue'
        ],
        [
            'color_id' => 3,
            'color_name' => 'green'
        ],
        [
            'color_id' => 4,
            'color_name' => 'yellow'
        ],
        [
            'color_id' => 5,
            'color_name' => 'black'
        ],
        [
            'color_id' => 6,
            'color_name' => 'white'
        ],
        [
            'color_id' => 7,
            'color_name' => 'pink'
        ],
        [
            'color_id' => 8,
            'color_name' => 'orange'
        ],
        [
            'color_id' => 9,
            'color_name' => 'purple'
        ]
    ];

// // create set colors
// function createColors($mysqli, $colors)
// {
//     foreach ($colors as $color) {
//         $color_id = $color['color_id'];
//         $color_name = $color['color_name'];

//         $sql = "INSERT INTO `colors`(`color_id`, `color_name`) VALUES ('$color_id', '$color_name')";
//         $mysqli->query($sql);
//     }
// }

// $mysqli = new mysqli("localhost", "root", "","shopping");
// createColors($mysqli, $colors);


function createColors($mysqli, $colors)
{
    $sql = "INSERT INTO `colors`(`color_name`) VALUES ('$colors')";
    $mysqli->query($sql);
}


//get all colors
function get_all_colors($mysqli)
{
    $sql = "SELECT * FROM `colors`";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return false;
}

//get colors by id
function getColorById($mysqli, $color_id)
{
    $sql = "SELECT * FROM `colors` WHERE `color_id` = $color_id";
    $result = $mysqli->query($sql);
    $color = $result->fetch_assoc();
    return $color;
}

//get colors by name
function getColorByName($mysqli, $color_name)
{
    $sql = "SELECT * FROM `colors` WHERE `color_name` = '$color_name'";
    $result = $mysqli->query($sql);
    $color = $result->fetch_assoc();
    return $color;
}

//update color by name
function updateColor($mysqli, $color_id, $color_name)
{
    $sql = "UPDATE `colors` SET `color_name` = '$color_name' WHERE `color_id` = $color_id";
    $result = $mysqli->query($sql);
    return $result;
}

//delete color by id
function deleteColor($mysqli, $color_id)
{
    $sql = "DELETE FROM `colors` WHERE `color_id` = $color_id";
    $result = $mysqli->query($sql);
    return $result;
}

// Get color by Pagination
function get_all_colors_pagination($mysqli, $limit, $offset)
{
    $sql = "SELECT * FROM `colors` 
            ORDER BY `color_id` DESC
            LIMIT $limit OFFSET $offset";

    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function get_total_colors_count($mysqli)
{
    $sql = "SELECT count(*) as total FROM `colors`";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}