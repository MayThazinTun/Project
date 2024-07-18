<?php 
session_start();

$cart = [];
$shirtCart = [];
$cate = [];
$order = [];
$order_total = [];
$order_invoice = [];

if(isset($_SESSION['products'])){
    $cart = $_SESSION['products'];
}

if(isset($_SESSION['category'])){
    $cate = $_SESSION['category'];
}

if(isset($_SESSION['order'])){
    $order = $_SESSION['order'];
}

if(isset($_SESSION['shirtCart'])){
    $shirtCart = $_SESSION['shirtCart'];
}

if(isset($_SESSION['orderTotal'])){
    $order_total= $_SESSION['orderTotal'];
}

if(isset($_SESSION['invoice_id'])){
    $order_invoice = $_SESSION['invoice_id'];
}