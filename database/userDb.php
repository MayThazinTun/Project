<?php

//create user
function create_user($mysqli, $name, $email, $address, $password, $role, $photo_paths)
{
    $sql = "INSERT INTO `users` (`name`, `email`, `address`, `password`, `role`, `images`) VALUES ('$name', '$email', '$address', '$password', '$role', '$photo_paths')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//get all users
function get_all_users($mysqli)
{
    $sql = "SELECT * FROM `users`";
    $result = $mysqli->query($sql);
    return $result;
}

//get user by id
function get_user_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `users` WHERE `id` = $id";
    $result = $mysqli->query($sql);
    return $result;
}

//get user by email

function get_user_by_email($mysqli, $email)
{
    $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function change_pw_by_id($mysqli, $id, $password){

    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE `users` SET `password` = '$password' where `id` = $id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//update user by id
function update_user_by_id($mysqli, $id, $name, $email, $address, $password, $role, $images)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE `users` SET `name`='$name',`email`='$email',`address`='$address', `password`='$password',`role`='$role',`images`='$images' WHERE `id` = $id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//delete user by id
function delete_user($mysqli, $id)
{
    $sql = "DELETE FROM `users` WHERE `id` = $id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}


function get_all_users_pagination($mysqli, $limit, $offset, $search)
{
    $search = mysqli_real_escape_string($mysqli, $search);
    $sql = "SELECT * FROM `users` 
            WHERE `name` LIKE '%$search%' OR `email` LIKE '%$search%'
            LIMIT $limit OFFSET $offset";

    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}

function get_total_user_count($mysqli, $search)
{
    $search = mysqli_real_escape_string($mysqli, $search);
    $sql = "SELECT count(*) as total FROM `users` WHERE `name` LIKE '%$search%' OR `email` LIKE '%$search%'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}
