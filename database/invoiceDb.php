<?php
// invoice_id,total_amount

function create_invoice($mysqli,$total_amount){
    $sql = "INSERT INTO `invoices`(`total_amount`) VALUES ($total_amount)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_all_invoices($mysqli){
    $sql = "SELECT * FROM `invoices`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_last_invoice($mysqli){
    $sql = "SELECT * FROM `invoices` ORDER BY `invoice_id` DESC LIMIT 1";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_invoice_by_id($mysqli, $id){
    $sql = "SELECT * FROM `invoices` WHERE `id` = $id";
    $result = $mysqli->query($sql);
    return $result;
}

function update_invoice_by_id($mysqli, $id, $invoice_id, $total_amount){
    $sql = "UPDATE `invoices` SET `invoice_id`=$invoice_id,`total_amount`=$total_amount WHERE `id` = $id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function delete_invoice_by_id($mysqli, $id){
    $sql = "DELETE FROM `invoices` WHERE `id` = $id";
    $result = $mysqli->query($sql);
    return $result;
}

?>