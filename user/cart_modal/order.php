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
$address = $user['address'];

if (isset($_POST['order'])) {
    $add = htmlspecialchars($_POST["address"]);
    $des = htmlspecialchars($_POST["description"]);
    array_push($order, [
        'name' => $name,
        'email' => $email,
        'address' => $add,
        'description' => $des
    ]);
    $_SESSION['order'] = $order;
    $modal_buy = true;
}

?>

<div class="modal fade" id="order" aria-hidden="true" aria-labelledby="order" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-4" id="order">Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $disabled = 'disabled';
                if ($cart != [] || $shirtCart!=[]) {
                    $disabled = '';
                    ?>
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
                                    <td><?php echo $shirtCart[$i]['total_price']*$shirtCart[$i]['qty'] ?> MMK </td>
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
                <?php } ?>
                <div>
                    <form method="post">
                        <div class="row justify-content-evenly">
                            <div class="form-group mb-2 col">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    aria-describedby="emailHelp" value="<?php echo $name ?>" disabled>
                            </div>
                            <div class="form-group mb-2 col">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    aria-describedby="emailHelp" value="<?php echo $email ?>" disabled>
                            </div>
                        </div>
                        <div class="row justify-content-evenly">
                            <div class="form-group mb-2 col">
                                <label for="address" class="form-label">Address</label>
                                <textarea type="text" class="form-control" id="address" name="address"
                                    aria-describedby="emailHelp"><?php echo $address ?></textarea>
                            </div>
                            <div class="form-group mb-2 col">
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                    aria-describedby="emailHelp"></textarea>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-dark" name="order" <?php echo $disabled ?>>Process to
                                Buy</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="d-none" id="modal_cart_buy" data-bs-target="#buy" data-bs-toggle="modal"
                    data-bs-dismiss="modal"></button>
            </div>

        </div>
    </div>
</div>