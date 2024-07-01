<?php 
session_start();

$cart = [];
$cate = [];

if(isset($_SESSION['products'])){
    $cart = $_SESSION['products'];
}

if(isset($_SESSION['category'])){
    $cate = $_SESSION['category'];
}