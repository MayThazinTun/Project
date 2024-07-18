<?php
require_once("../database/add_to_cart.php");
require_once("../database/invoiceDb.php");

$cookie_user = null;
if (isset($_COOKIE['user'])) {
    $cookie_user = json_decode($_COOKIE['user'], true);
}
$id = $cookie_user['id'];
$users = get_user_by_id($mysqli, $id);
$user = $users->fetch_assoc();
$name = $user['name'];
$email = $user['email'];
// foreach ($order as $o) {
//     $address = $o['address'];
//     $description = $o['description'];
// }

if (isset($_SESSION['invoice_id'])) {
    $orders = get_order_by_invoice_id($mysqli, $order_invoice);
}
$close = false;
if (isset($_POST['refresh']) || isset($_POST['download'])) {
    $close = true;
    session_destroy();
    echo "<script>window.location.href ='./carts.php' </script>";
}

?>
<div class="modal fade" id="invoice" aria-hidden="true" aria-labelledby="invoice" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoice">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding-left:150px;">
                <div class="card p-3" id="invoice_data" style="width:80%; height:auto">
                    <div class=" d-flex justify-content-center">
                        <img src="../images/Logo1.png" style="width:80px; height:auto;">
                        <h4 class="py-3">Tee World Myanmar</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="text-secondary">
                            invoice_id : <?php echo $order_invoice ?> <br>
                            user_name : <?php echo $name ?> <br>
                            user_email : <?php echo $email ?> <br>
                            user_address : <?php //echo $address ?> <br>
                        </p>
                        <p class="text-end text-secondary">
                            <?php
                            $o = get_order_by_invoice_id($mysqli, $order_invoice)->fetch_assoc();
                            echo $o['created_at'];
                            ?>
                        </p>
                    </div>
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Order_id</th>
                                    <th scope="col">Product_id</th>
                                    <th scope="col">Product_name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td colspan="4" class="text-end fs-5 pe-5 fw-bold">All total</td>
                                    <td class="fs-6 fw-bold">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="fs-5">Contact Us</div>
                        <p>ph no <br>
                            address <br>
                            email
                        </p>
                    </div>
                    <div class="text-center">
                        <img src="../images/Thank_you.jpg" style="width:100px; height:auto;">
                    </div>
                </div>
                <!-- <div class="invoice-box" id="invoice_data">
                    <table cellpadding="0" cellspacing="0">
                        <tr class="top">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td class="title">
                                            <h1>Invoice</h1>
                                        </td>
                                        <td>
                                            Invoice #: 123<br>
                                            Created: January 1, 2024<br>
                                            Due: February 1, 2024
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="information">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td>
                                            Acme Corp.<br>
                                            John Doe<br>
                                            john@example.com
                                        </td>
                                        <td>
                                            Company Inc.<br>
                                            Jane Smith<br>
                                            jane@example.com
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="heading">
                            <td>Item</td>
                            <td>Price</td>
                        </tr>
                        <tr class="item">
                            <td>Website design</td>
                            <td>$300.00</td>
                        </tr>
                        <tr class="item last">
                            <td>Hosting (3 months)</td>
                            <td>$75.00</td>
                        </tr>
                        <tr class="total">
                            <td></td>
                            <td>Total: $375.00</td>
                        </tr>
                    </table>
                </div> -->
            </div>
            <div class="modal-footer">
                <form method="post">
                    <button type="button" onclick="location.replace('../user/carts.php')" name="refresh" class="btn btn-secondary">Close</button>
                    <button class="btn btn-dark" name='download' id="download">Dowload invoice</button>
                </form>
                <button class="d-none" id="close" data-bs-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>