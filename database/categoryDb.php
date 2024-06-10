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
    $sql = "SELECT * FROM `categories` WHERE `category_id`='$category_id'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

//update category by id
function update_category_by_id($mysqli, $category_id, $category_name)
{
    $sql = "UPDATE `categories` SET `category_name`='$category_name' WHERE `category_id`='$category_id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//delete category by id
function delete_category_by_id($mysqli, $category_id)
{
    $sql = "DELETE FROM `categories` WHERE `category_id`='$category_id'";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
