<?php

//create category
function create_category($mysqli, $category_name)
{
    $sql = "INSERT INTO `categories`(`category_name`) VALUES ('$category_name')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
// //create 7 categories
//     $mysqli = new mysqli("localhost", "root", "", "shopping");
//     for ($i = 1; $i < 8; $i++) {
//         create_category($mysqli, "Category $i");
//     }

// get all categories
function get_all_categories($mysqli)
{
    $sql = "SELECT * FROM `categories`";
    $result = $mysqli->query($sql);
    return $result;
}

// get category by id
function get_category_by_id($mysqli, $category_id)
{
    $sql = "SELECT * FROM `categories` WHERE `category_id`=$category_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

//update category by id
function update_category_by_id($mysqli, $category_id, $category_name)
{
    $sql = "UPDATE `categories` SET `category_name`='$category_name' WHERE `category_id`=$category_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//delete category by id
function delete_category_by_id($mysqli, $category_id)
{
    try {
        // Attempt to execute the query
        $sql = "DELETE FROM `categories` WHERE `category_id`=$category_id";
        if ($mysqli->query($sql) === TRUE) {
            return true;
        } else {
            throw new Exception($mysqli->error);
        }
    } catch (Exception $e) {
        // Handle any errors
        echo "Error deleting category: " . $e->getMessage();
        return false;
    }
}


function get_all_categories_pagination($mysqli, $limit, $offset)
{
    $sql = "SELECT * FROM `categories` 
            ORDER BY `category_id` DESC
            LIMIT $limit OFFSET $offset";

    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}


function get_total_category_count($mysqli)
{
    $sql = "SELECT count(*) as total FROM `categories`";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}
