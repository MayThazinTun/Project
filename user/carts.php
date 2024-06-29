<?php require_once ("./Layout/header.php");
require_once ("../database/add_to_cart.php");

$checked = "";
//var_dump($_POST['selected']);
if (isset($_POST['selected'])) {
    $checked = 'checked';
    // echo 'checked';
}
if (isset($_POST['deselect'])) {
    $checked = "";
}

if(isset($_GET['dec'])){
    $index = $_GET['dec'];
    $current = --$cart[$index]['product_quantity'];
    if($current>0){
        $cart[$index]['total_amount'] =
        $cart[$index]['product_quantity']*$cart[$index]['product_price'];
    }else {
        unset($cart[$index]);
    }
    $cart = array_values($cart);
    $_SESSION['products']= $cart;
    header("Location:./carts.php");
}

if(isset($_GET['delete'])){
    $index = $_GET['delete'];
    unset($cart[$index]);
    $cart = array_values($cart);
    $_SESSION['products']= $cart;
    header("Location:./carts.php");
}

?>

<div class="row me-1">
    <div class="col-auto">
        <?php require_once ("./Layout/sidebar.php") ?>
    </div>
    <div class="col p-3">
        <div class="row">
            <div class="col-9">
                <div class="card p-3 " style="height: 80vh;">
                    <form method="post">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-dark" name="selected">Select All</button>

                            <button type="submit" class="btn btn-secondary" name="deselect">Deselect</button>

                            <!-- <input class="form-check-input" type="checkbox" name="selected" value="1"
                                id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Select All
                            </label> -->
                        </div>
                        <hr>
                        <!-- list of product that customer add to cart -->
                        <div class="overflow-auto" style="height:60vh;">
                            <?php for ($i = 0; $i < count($cart); $i++) { ?>
                                <div class="form-check d-flex">
                                    <input class="form-check-input" type="checkbox" <?php echo $checked ?>>
                                    <label class="form-check-label" for="flexCheckChecked" style="width: 700px;">
                                        <div class="row justify-content-evenly">
                                            <div class="col-3 text-center">
                                                <?php $photos = explode(',', $cart[$i]['product_images']);
                                                if (!empty($photos[0])): ?>
                                                    <img src="<?php echo htmlspecialchars($photos[0]); ?>" class="rounded"
                                                        style="max-width: 20rem; max-height: 30rem;" alt="Product Image">
                                                <?php else: ?>
                                                    <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded"
                                                        style="width:100px; height:100px;" alt="No Image Available">
                                                <?php endif; ?>
                                                <!-- <img src="<?php //echo $cart[$i]['product_images'] ?>" alt="" style="width:auto; height:80px;"> -->
                                            </div>
                                            <div class="col-3 text-center">
                                                <h6><?php echo $cart[$i]['product_name'] ?></h6>
                                            </div>
                                            <div class="col-3 text-center">
                                                <p>
                                                    Size : <?php echo $cart[$i]['product_size'] ?><br>
                                                    Color : <?php echo $cart[$i]['product_color'] ?><br>
                                                    Price : <?php echo $cart[$i]['product_price'] ?>MMK<br>
                                                </p>
                                            </div>
                                            <div class="col-1 text-center">
                                                <p> Qty <?php echo $cart[$i]['product_quantity'] ?> </p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <?php echo $cart[$i]['total_amount'] ?>MMK
                                            </div>
                                        </div>

                                    </label>
                                    <div class="d-flex flex-column">
                                        <a href="./carts.php?dec=<?php echo $i ?>" class="btn" name="dec"><i class="fa-solid fa-delete-left"
                                                style="color: #a8a8a8;"></i></a>
                                        <a href="./carts.php?delete=<?php echo $i ?>" class="btn" name="delect"><i class="fa-solid fa-trash-can"
                                                style="color: #98999a;"></i></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-3">
                <div class="card p-3">
                    <h5 class="card-title">Order Summary</h5>
                    <hr>
                    <div class="card-text">
                        <p>product type : count price</p>
                        <!-- sometime discount will be include -->
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5>Total</h5>
                            <h5>total price</h5>
                        </div>
                    </div>
                    <div class="d-grid">
                        <?php require_once ("./order.php") ?>
                        <?php require_once ("./buy.php") ?>
                        <?php require_once ("./invoice.php"); ?>
                        <a class="btn btn-dark" data-bs-toggle="modal" href="#order" role="button">Process
                            to Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ("./Layout/footer.php") ?>