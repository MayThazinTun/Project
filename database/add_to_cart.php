<?php 
session_start();

$cart = [];

if(isset($_SESSION['products'])){
    $cart = $_SESSION['products'];
}