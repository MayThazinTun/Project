<?php

//create user
function create_user($mysqli, $name, $email, $password, $role)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `users`(`name`,`email`,`password`,`role`) VALUES ('$name','$email','$password','$role')";
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
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

//get user by id
function get_user_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `users` WHERE `id` = $id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

//update user by id
function update_user_by_id($mysqli, $id, $name, $email, $password, $role)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE `users` SET `name`='$name',`email`='$email',`password`='$password',`role`='$role' WHERE `id` = $id";
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
