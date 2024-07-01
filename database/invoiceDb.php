<?php
// invoice_id,total_amount

function create_invoice($mysqli, $invoice_id, $total_amount){
    $sql = "INSERT INTO `invoices`(`invoice_id`, `total_amount`) VALUES ($invoice_id,$total_amount)";
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