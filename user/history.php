<?php
require_once("../database/index.php");
require_once("../database/invoiceDb.php");
require_once("../database/orderDb.php");
require_once('../database/userDb.php');
require_once('../database/productDb.php');
require_once('../database/itemDb.php');
require_once('../database/typeDb.php');
require_once("../database/colorDb.php");
require_once("../database/sizeDb.php");
require_once("../database/stickerDb.php");

$cookie_user = null;
if (isset($_COOKIE['user'])) {
    $cookie_user = json_decode($_COOKIE['user'], true);
}
$id = $cookie_user['id'];
$users = get_user_by_id($mysqli, $id);
$user = $users->fetch_assoc();
$name = $user['name'];
$email = $user['email'];
$address = $description = "";

$user_orders = get_order_by_user_id($mysqli, $id);
// var_dump($user_orders->fetch_all(MYSQLI_ASSOC));

require_once("./Layout/header.php");

?>

<div class="row">
    <div class="col-auto">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow" style="width: 200px; height:92vh">
            <div class="fs-5 ps-3">
                HISTORY
            </div>
            <hr>
            <div class="btn-group-vertical gap-2">

                <button class="btn btn-outline-secondary border-0 text-start ps-4">Invoices</button>

                <!-- <button class="btn btn-outline-secondary border-0 text-start ps-4">Orders</button> -->

            </div>
        </div>
    </div>
    <div class="col overflow-auto" style="height:90vh;">
        <?php
        if ($user_orders) {
            $user_order = $user_orders->fetch_all(MYSQLI_ASSOC);
            // var_dump($user_order);
            foreach ($user_order as $uo) {
                $order_count = 0;
                // var_dump($uo);
                $address = $uo['shipping_address'];
                $description = $uo['order_description'];
                $iv_order = (get_order_by_invoice_id($mysqli, $uo['invoice_id']))->fetch_all(MYSQLI_ASSOC);
                // echo $uo['invoice_id'];
                $iv_total = (get_invoice_by_id($mysqli, $uo['invoice_id']))->fetch_assoc();
                // var_dump($iv_total);
                foreach ($iv_order as $io) {
                    $order_count = $order_count + $io['order_quantity'];
                }
                // var_dump($order_count);
        ?>
                <div class="card m-4 pt-2 shadow-lg">
                    <div class="row text-secondary">
                        <div class="col-auto mx-3 my-4 text-center">
                            #<?php echo $uo['invoice_id']; ?>
                        </div>
                        <div class="col my-4 text-center">
                            Thank for your support!
                        </div>
                        <div class="col my-4 text-center">
                            <?php echo $order_count; ?> products
                        </div>
                        <div class="col my-4 text-center">
                            <?php echo substr($uo['created_at'], 0, 10); ?>
                        </div>
                        <div class="col my-4 text-center">
                            <button class="btn border border-1 btn-outline-secondary" data-bs-target="#view_details-<?php echo $uo['invoice_id'] ?>" data-bs-toggle="modal" data-bs-dismiss="modal">View details</button>
                        </div>
                        <div class="modal fade" id="view_details-<?php echo $uo['invoice_id'] ?>" aria-hidden="true" aria-labelledby="view_details" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <!-- modal for invoice history -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="invoice">Invoice</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="padding-left:150px;">
                                        <div class="card p-3" id="invoice_data" style="width:90%; height:auto">
                                            <div class=" d-flex justify-content-center">
                                                <img src="../images/Logo1.png" style="width:80px; height:auto;">
                                                <h4 class="py-3">Tee World Myanmar</h4>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-secondary text-start">
                                                    Invoice_ID : <?php echo $io['invoice_id'] ?> <br>
                                                    User_name : <?php echo $name ?> <br>
                                                    Email : <?php echo $email ?> <br>
                                                    Address : <?php echo $address ?> <br>
                                                    Description : <?php echo $description ?>
                                                </p>
                                                <p class="text-end text-secondary">
                                                    Date : <?php echo substr($io['created_at'], 0, 10) ?>
                                                </p>
                                            </div>
                                            <div>
                                                <table class="table">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th scope="col">#</th>
                                                            <th scope="col">Order_id</th>
                                                            <th scope="col">Products</th>
                                                            <th scope="col">Product_name</th>
                                                            <th scope="col">Qty</th>
                                                            <th scope="col">Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($iv_order as $io) {
                                                            if ($io['product_id'] != null) {
                                                                $o_product = get_product_by_id($mysqli, $io['product_id']);
                                                        ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $i + 1 ?></th>
                                                                    <td>
                                                                        <p><?php echo $io['order_id'] ?></p>
                                                                    </td>
                                                                    <td>
                                                                        <p><?php
                                                                            $photos = explode(',', $o_product['product_images']);
                                                                            $dir = "../images/All/products/" . $photos[0];
                                                                            if (!empty($photos[0])) : ?>
                                                                                <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image">
                                                                            <?php else : ?>
                                                                                <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available">
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p><?php echo $o_product['product_name'] ?></p>
                                                                    </td>
                                                                    <td>
                                                                        <p><?php echo $io['order_quantity'] ?></p>
                                                                    </td>
                                                                    <td>
                                                                        <p><?php echo $o_product['product_price'] * $io['order_quantity']  ?> MMK </p>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                $i++;
                                                            }
                                                            // echo $io['item_id'];
                                                            if ($io['item_id'] != null) {
                                                                $o_item = get_item_by_id($mysqli, $io['item_id']);
                                                            ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $i + 1 ?></th>
                                                                    <td>
                                                                        <p><?php echo $io['order_id'] ?></p>
                                                                    </td>
                                                                    <td>
                                                                        <p>
                                                                            <?php
                                                                            $type_img = (get_type_by_id($mysqli, $o_item['type_id']))->fetch_assoc();
                                                                            $photos = explode(',', $type_img['type_images']);
                                                                            $dir = "../images/All/types/" . $photos[0];
                                                                            if (!empty($photos[0])) :
                                                                            ?>
                                                                                <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image">
                                                                            <?php else : ?>
                                                                                <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available">
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    </td>
                                                                    <td class="d-flex justify-content-between" style="height:110px;">
                                                                        <?php
                                                                        $o_color = (getColorById($mysqli, $o_item['color_id']))->fetch_assoc();
                                                                        $o_size = (getSizeById($mysqli, $o_item['size_id']))->fetch_assoc();
                                                                        if ($o_item['sticker_id'] != null) {
                                                                            $o_sticker = (get_sticker_by_id($mysqli, $o_item['sticker_id']))->fetch_assoc();
                                                                        } else {
                                                                            $o_sticker = false;
                                                                        }
                                                                        ?>
                                                                        <div>
                                                                            <div class="border border-1 rounded ms-4" style="width:30px; height:30px; background-color:<?php echo $o_color['color_name'] ?>"></div>
                                                                            <div class="border border-1 rounded text-center ms-4" style="width:30px; height:30px;"><?php echo $o_size['size'] ?></div>
                                                                        </div>
                                                                        <div>
                                                                            <?php
                                                                            if ($o_sticker) {
                                                                                $photos = explode(',', $o_sticker['sticker_images']);
                                                                                $dir = "../images/All/stickers/" . $photos[0];
                                                                                if (!empty($photos[0])) : ?>
                                                                                    <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image"> <br>
                                                                                <?php endif;
                                                                            } else { ?>
                                                                                <!-- <img src=<?php //echo "../images/All/default_image.jpg" 
                                                                                                ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available"> <br> -->
                                                                                No stickers included!
                                                                            <?php } ?>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?php echo $io['order_quantity'] ?></p>
                                                                    </td>
                                                                    <td>
                                                                        <p><?php echo $o_item['item_price'] * $io['order_quantity']  ?> MMK </p>
                                                                    </td>
                                                                </tr>
                                                        <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td colspan="5" class="text-end fs-5 pe-5 fw-bold">All total</td>
                                                            <td class="fs-6 fw-bold text-end">
                                                                <?php
                                                                echo $iv_total['total_amount'];
                                                                ?>MMK
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-start">
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
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="location.replace('../user/history.php')" name="refresh" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>
<?php require_once("./Layout/footer.php") ?>