<?php
$type = [];
$color = [];
$size = [];
$sticker = [];
$shirtNote = [];

if(isset($_SESSION['type'])){
    $type = $_SESSION['type'];
}
if(isset($_SESSION['color'])){
    $color = $_SESSION['color'];
}
if(isset($_SESSION['size'])){
    $size = $_SESSION['size'];
}
if(isset($_SESSION['sticker'])){
    $sticker = $_SESSION['sticker'];
}
if(isset($_SESSION['note'])){
    $shirtNote = $_SESSION['note'];
}