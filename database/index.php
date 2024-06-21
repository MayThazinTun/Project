<?php


$mysqli = new mysqli("localhost", "root", "");

if ($mysqli->connect_errno) {
    echo "connection error";
}

// create Database 
function createDatabase($mysqli)
{
    $sql = "CREATE DATABASE IF NOT EXISTS shopping";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//drop database
function dropDatabase($mysqli)
{
    $sql = "DROP DATABASE IF EXISTS shopping";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//select database
function selectDatabase($mysqli)
{
    $sql = "USE shopping";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}



//create users table /name,email,password,role[admin/user],images user connect with orders table
function createUsersTable($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS users(
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') DEFAULT 'user',
        images VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function createDefaultAdmin($mysqli)
{
    $email = 'admin@gmail.com';
    $password = password_hash("123", PASSWORD_DEFAULT);

    $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows == 0) {
        $sql = "INSERT INTO `users` (`name`, `email`, `password`, `role`, `images`) VALUES ('admin', '$email', '$password', 'admin', null)";
        return $mysqli->query($sql);
    }
    return false;
}

//create orders table /order_id,user_id,product_id,invoice_id,shipping_address,created_at,updated_at order connect with users table and products table
function createOrdersTable($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS orders(
        order_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        product_id INT(11) NOT NULL,
        invoice_id INT(11) NOT NULL,
        -- shipping_address VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (product_id) REFERENCES products(id)
        FOREIGN KEY (invoice_id) REFERENCES invoices(invoice_id)
    )";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//create invoices table /invoice_id,total_amount
function createInvoiceTable($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS invoices(
        invoice_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        total_amount INT(11) NOT NULL
    )";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//create categories table /category_id,category_name
function createCategoriesTable($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS categories(
        category_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(255) NOT NULL
    )";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//Product connect with (categories,types,colors,sizes,stickers) tables
//create products table product_id,category_id,type_id,color_id,size_id,sticker_id,product_name,product_price,product_quantity,product_images,description,created_at,updated_at
function createProductsTable($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS products(
        product_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        category_id INT(11) NOT NULL,
        type_id INT(11),
        color_id INT(11),
        size_id INT(11),
        sticker_id INT(11),
        product_name VARCHAR(255) NOT NULL,
        product_price INT(11) NOT NULL,
        product_quantity INT(11) NOT NULL,
        -- product_images VARCHAR(255),
        -- product_description VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(category_id),
        FOREIGN KEY (type_id) REFERENCES types(type_id),
        FOREIGN KEY (color_id) REFERENCES colors(color_id),
        FOREIGN KEY (size_id) REFERENCES sizes(size_id)
    )";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//create types table type_id,type_price,type_Image product prices can change depend on type
function createTypesTable($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS types(
        type_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        type_price INT(11) DEFAULT 0,
        type_images VARCHAR(255)
    )";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//create colors table color_id,color_name
function createColorsTable($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS colors(
        color_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        color_name VARCHAR(255) NOT NULL
    )";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

//create sizes table size_id,size,size_price product can change depend on sizes
function createSizesTable($mysqli) {
    $sql = "CREATE TABLE IF NOT EXISTS sizes(
        size_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        size VARCHAR(255) NOT NULL,
        size_price INT(11) DEFAULT 0
    )";
    return $mysqli->query($sql);
}


//create stickers table sticker_id,sticker_price,sticker_images product can change depend on stickers
function createStickersTable($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS stickers(
        sticker_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        sticker_price INT(11) DEFAULT 0,
        sticker_images VARCHAR(255)
    )";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

// first create database and select database 
// second create users table
// third create categories table
// fourth create types,colors,sizes,stickers tables
// fifth create products table
//connect products table with categories,types,colors,sizes,stickers tables


//To create all tables in one function
function allTables($mysqli)
{
    createDatabase($mysqli);
    selectDatabase($mysqli);
    createUsersTable($mysqli);
    createCategoriesTable($mysqli);
    createTypesTable($mysqli);
    createColorsTable($mysqli);
    createSizesTable($mysqli);
    createStickersTable($mysqli);
    createProductsTable($mysqli);
    createInvoiceTable($mysqli);
    createDefaultAdmin($mysqli);
    // echo "all tables created successfully";
}
allTables($mysqli);


// Drop Database
// dropDatabase($mysqli);
