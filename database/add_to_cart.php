<?php 
session_start();

$cart = [];
$cate = [];
$order = [];

if(isset($_SESSION['products'])){
    $cart = $_SESSION['products'];
}

if(isset($_SESSION['category'])){
    $cate = $_SESSION['category'];
}

if(isset($_SESSION['order'])){
    $order = $_SESSION['order'];
}