<?php
require_once ("../database/add_to_cart.php");

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
if (isset($_POST['pay'])) {
    $modal_invoice = true;
}

?>
<div class="modal fade" id="buy" aria-hidden="true" aria-labelledby="buy" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buy">Buy</h5>
                <form action="">
                    <button type="button" class="btn-close" name="close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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
                                    $total = ($total + $tt['total_price'])*$tt['qty'];
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
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                                value="<?php echo $name ?>" disabled>
                        </div>
                        <div class="form-group mb-2 col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                value="<?php echo $email ?>" disabled>
                        </div>
                    </div>
                    <div class="row justify-content-evenly">
                        <div class="form-group mb-2 col">
                            <label for="address" class="form-label">Address</label>
                            <textarea type="text" class="form-control" id="address" aria-describedby="emailHelp"
                                disabled><?php echo $address ?></textarea>
                        </div>
                        <div class="form-group mb-2 col">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" aria-describedby="emailHelp"
                                disabled><?php echo $description ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="post">
                    <button class="btn btn-secondary" name="back">Back</button>
                    <button class="btn btn-dark" name="pay">Pay</button>
                </form>
                <button class="d-none" id="back" data-bs-target="#order" data-bs-toggle="modal"
                    data-bs-dismiss="modal"></button>
                <button class="d-none" id="vouchar" data-bs-target="#invoice" data-bs-toggle="modal"
                    data-bs-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>