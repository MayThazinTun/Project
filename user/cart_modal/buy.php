<?php
require_once("../database/add_to_cart.php");
require_once("../database/invoiceDb.php");
require_once("../database/itemDb.php");
require_once("../database/orderDb.php");

$cookie_user = null;
if (isset($_COOKIE['user'])) {
    $cookie_user = json_decode($_COOKIE['user'], true);
}
$id = $cookie_user['id'];
$users = get_user_by_id($mysqli, $id);
$user = $users->fetch_assoc();
$name = $user['name'];
$email = $user['email'];
foreach ($order as $o) {
    $address = $o['address'];
    $description = $o['description'];
}
if (isset($_POST['back']) || isset($_POST['close'])) {
    unset($_SESSION['order']);
    $modal_order = true;
}
$type_id = $size_id = $color_id = $sticker_id = $item_price = $item_quantity = $item_note = $orderTotal = "";
$product_id = $item_id = null;
if (isset($_POST['pay'])) {
    $modal_invoice = true;
    if (isset($_SESSION['orderTotal'])) {
        foreach ($order_total as $ot) {
            $orderTotal = $ot;
        }
    }
    if(create_invoice($mysqli, $orderTotal)){
        $creInvoice = get_last_invoice($mysqli);
    }
    if (isset($_SESSION['shirtCart']) && $_SESSION['shirtCart']!= []) {
        foreach ($shirtCart as $sc) {
            $type_id = $sc['type_id'];
            $size_id = $sc['size_id'];
            $color_id = $sc['color_id'];
            $sticker_id = $sc['sticker_id'];
            $item_price = $sc['total_price'];
            $item_quantity = $sc['qty'];
            $item_note = $sc['note'];
        }
        if (empty($sticker_id) && empty($item_note)) {
            if(create_item($mysqli, $type_id, $color_id, $size_id, $sticker_id, $item_price, $item_quantity, $item_note)){
                $creItem = get_last_item($mysqli);
            }
        } else {
            if(createItemsAll($mysqli, $type_id, $color_id, $size_id, $sticker_id, $item_price, $item_quantity, $item_note)){
                $creItem = get_last_item($mysqli);
            }
        }
        $status = create_order_item($mysqli, $id, $product_id, $creItem['item_id'],"item", $creInvoice['invoice_id'],$item_quantity, $address, $description);
        // var_dump($status);
        // exit();
    }
    if (isset($_SESSION['products'])) {
        foreach ($cart as $c) {
            $updateProduct = get_product_by_id($mysqli, $c['product_id']);
            $updateProduct['product_quantity'] = $updateProduct['product_quantity'] - $c['product_quantity'];
            update_product(
                $mysqli,
                $updateProduct['product_id'],
                $updateProduct['category_id'],
                $updateProduct['product_name'],
                $updateProduct['product_size'],
                $updateProduct['product_color'],
                $updateProduct['product_quantity'],
                $updateProduct['product_price'],
                $updateProduct['product_images'],
                $updateProduct['product_description']
            );
            $status = create_order_product($mysqli, $id, $c['product_id'], $item_id,"product", $creInvoice['invoice_id'],$c['product_quantity'], $address, $description);
        }
    }
    unset($_SESSION['products']);
    unset($_SESSION['shirtCart']);
    unset($_SESSION['orderTotal']);
    unset($_SESSION['category']);
    $_SESSION['invoice_id']=$creInvoice['invoice_id'];
    // session_destroy();
    // header("Location:./carts.php");
    // echo "<script>window.location.href ='./carts.php' </script>";
}

?>
<div class="modal fade" id="buy" aria-hidden="true" aria-labelledby="buy" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buy">Buy</h5>
                <form action="">
                    <button type="button" class="btn-close" name="close" data-bs-dismiss="modal" aria-label="Close"></button>
                </form>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($shirtCart); $i++) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $i + 1 ?></th>
                                <td><?php echo $shirtCart[$i]['type_name'] ?></td>
                                <td><?php echo $shirtCart[$i]['total_price'] ?> MMK </td>
                                <td><?php echo $shirtCart[$i]['qty'] ?></td>
                                <td><?php echo $shirtCart[$i]['total_price'] * $shirtCart[$i]['qty'] ?> MMK </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <?php
                        for ($i = 0; $i < count($cart); $i++) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $i + 1 ?></th>
                                <td><?php echo $cart[$i]['product_name'] ?></td>
                                <td><?php echo $cart[$i]['product_price'] ?> MMK </td>
                                <td><?php echo $cart[$i]['product_quantity'] ?></td>
                                <td><?php echo $cart[$i]['total_amount'] ?> MMK </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-end fs-4 pe-5 fw-bold">All total</td>
                            <td class="fs-5 fw-bold">
                                <?php
                                $total = 0;
                                foreach ($cart as $amount) {
                                    $total = $total + $amount['total_amount'];
                                }
                                foreach ($shirtCart as $tt) {
                                    $total = ($total + $tt['total_price']) * $tt['qty'];
                                }
                                echo $total;
                                ?>MMK
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <div class="row justify-content-evenly">
                        <div class="form-group mb-2 col">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" value="<?php echo $name ?>" disabled>
                        </div>
                        <div class="form-group mb-2 col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?php echo $email ?>" disabled>
                        </div>
                    </div>
                    <div class="row justify-content-evenly">
                        <div class="form-group mb-2 col">
                            <label for="address" class="form-label">Address</label>
                            <textarea type="text" class="form-control" id="address" aria-describedby="emailHelp" disabled><?php echo $address ?></textarea>
                        </div>
                        <div class="form-group mb-2 col">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" aria-describedby="emailHelp" disabled><?php echo $description ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="post">
                    <button class="btn btn-secondary" name="back">Back</button>
                    <button class="btn btn-dark" name="pay">Pay</button>
                </form>
                <button class="d-none" id="back" data-bs-target="#order" data-bs-toggle="modal" data-bs-dismiss="modal"></button>
                <button class="d-none" id="vouchar" data-bs-target="#invoice" data-bs-toggle="modal" data-bs-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>