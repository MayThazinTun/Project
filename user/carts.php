<?php
require_once("../database/index.php");
require_once("../database/categoryDb.php");
require_once("../database/productDb.php");
require_once("../database/add_to_cart.php");
require_once("../database/invoiceDb.php");
require_once("../database/itemDb.php");
require_once("../database/orderDb.php");
// require_once ("./cart_modal/order.php");
// require_once ("./cart_modal/buy.php");
// require_once ("./cart_modal/invoice.php");

$modal_buy = $modal_order = $modal_invoice = $close = false;
if (isset($_GET['dec'])) {
    $index = $_GET['dec'];
    $current = --$cart[$index]['product_quantity'];
    $ctg = $cart[$index]['category_id'];

    if ($current > 0) {
        $cart[$index]['total_amount'] =
            $cart[$index]['product_quantity'] * $cart[$index]['product_price'];
    } else {
        unset($cart[$index]);
    }

    for ($i = 0; $i < count($cate); $i++) {
        if ($cate[$i]['category_id'] == $ctg) {
            $ct_qty = --$cate[$i]['category_qty'];
            if ($ct_qty > 0) {
                $cate[$i]['amount'] = $cate[$i]['category_qty'] * $cate[$i]['price'];
            } else {
                unset($cate[$i]);
            }
        }
    }
    $cart = array_values($cart);
    $cate = array_values($cate);
    $_SESSION['products'] = $cart;
    $_SESSION['category'] = $cate;
    header("Location:./carts.php");
}

if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    $ctg = $cart[$index]['category_id'];
    //$cart_qty = $cart[$index]['product_quantity'];

    for ($i = 0; $i < count($cate); $i++) {
        if ($cate[$i]['category_id'] == $ctg) {
            $cate[$i]['category_qty'] = $cate[$i]['category_qty'] - $cart[$index]['product_quantity'];
            if ($cate[$i]['category_qty'] == 0) {
                unset($cate[$i]);
            }
        }
    }
    unset($cart[$index]);
    $cart = array_values($cart);
    $cate = array_values($cate);
    $_SESSION['products'] = $cart;
    $_SESSION['category'] = $cate;
    header("Location:./carts.php");
}
if (isset($_GET['delect'])) {
    unset($_SESSION['shirtCart'][$_GET['delect']]);
    header("Location:./carts.php");
}
require_once("./Layout/header.php");

?>

<div class="row me-1">
    <div class="col-auto">
        <div class="shadow">
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-white" style="width: 200px; height:100vh;">
                <div class="fs-5 ps-3">
                    Catagories
                </div>
                <hr>
                <div class="btn-group-vertical gap-2">

                    <button class="btn btn-outline-secondary border-0 text-start ps-4" onclick="location.href='./carts.php'">All</button>
                    <?php
                    $categories = get_all_categories($mysqli);
                    while ($category = $categories->fetch_assoc()) {
                    ?>
                        <button class="btn btn-outline-secondary border-0 text-start ps-4" onclick="location.href='./carts.php?category_id=<?php echo $category['category_id'] ?>';">
                            <?php echo $category['category_name'] ?>
                        </button>
                    <?php
                    }
                    ?>
                    <!-- <button class="btn btn-outline-secondary border-0 text-start ps-4">database</button> -->

                </div>
            </div>
            <?php //var_dump($category) 
            ?>
        </div>
    </div>
    <div class="col p-3">
        <div class="row">
            <div class="col-9">
                <div class="card p-3 ps-5 shadow p-3 mt-2 mb-3 bg-body rounded" style="height: 90vh; width: auto;">
                    <form method="post">
                        <!-- list of product that customer add to cart -->
                        <div class="overflow-auto" style="height:70vh;">
                            <?php
                            if (!isset($_GET['category_id'])) {
                                if (count($cart) === 0 && count($shirtCart) === 0) {
                                    echo "<h3 class='text-secondary text-center'> No products are added to cart yet <h3>";
                                }
                                if (isset($_SESSION['shirtCart'])) {
                                    for ($i = 0; $i < count($shirtCart); $i++) { ?>
                                        <div class="d-flex">
                                            <div class="row justify-content-evenly" style="width:700px;">
                                                <div class="col-3 text-center">
                                                    <?php $photos = explode(',', $shirtCart[$i]['type_images']);
                                                    $dir = "../images/All/types/" . $photos[0];
                                                    if (!empty($photos[0])) : ?>
                                                        <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:170px; height:100px;" alt="Product Image">
                                                    <?php else : ?>
                                                        <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:170px; height:100px;" alt="No Image Available">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-3 ps-5">
                                                    <h6><?php echo $shirtCart[$i]['type_name'] ?></h6>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <p style="display:inline;">
                                                        Size : <?php echo $shirtCart[$i]['size'] ?><br>
                                                        Color
                                                    <div class="border border-1 rounded" style="margin-left: 60px; width:30px; height:30px; background-color:<?php echo $shirtCart[$i]['color_name'] ?>">
                                                    </div>
                                                    Price : <?php echo $shirtCart[$i]['total_price'] ?>MMK<br>
                                                    </p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <p> Qty <?php echo $shirtCart[$i]['qty'] ?> </p>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <?php echo $shirtCart[$i]['total_price'] * $shirtCart[$i]['qty'] ?>MMK
                                                </div>
                                            </div>
                                            <div>
                                                <a href="./carts.php?delect=<?php echo $i ?>" class="btn" name="delect"><i class="fa-solid fa-trash-can" style="color: #98999a;"></i></a>
                                            </div>
                                        </div>
                                <?php }
                                } ?>

                                <?php
                                for ($i = 0; $i < count($cart); $i++) {
                                ?>
                                    <div class="d-flex">
                                        <div class="row justify-content-evenly" style="width:700px;">
                                            <div class="col-3 text-center">
                                                <?php $photos = explode(',', $cart[$i]['product_images']);
                                                $dir = "../images/All/products/" . $photos[0];
                                                if (!empty($photos[0])) : ?>
                                                    <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:170px; height:100px;" alt="Product Image">
                                                <?php else : ?>
                                                    <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:170px; height:100px;" alt="No Image Available">
                                                <?php endif; ?>
                                                <!-- <img src="<?php //echo $cart[$i]['product_images'] 
                                                                ?>" alt="" style="width:auto; height:80px;"> -->
                                            </div>
                                            <div class="col-3 ps-5">
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
                                        <div class="d-flex flex-column ">
                                            <a href="./carts.php?dec=<?php echo $i ?>" class="btn" name="dec"><i class="fa-solid fa-delete-left" style="color: #a8a8a8;"></i></a>
                                            <a href="./carts.php?delete=<?php echo $i ?>" class="btn" name="delect"><i class="fa-solid fa-trash-can" style="color: #98999a;"></i></a>
                                        </div>
                                    </div>
                                    <?php }
                            } else {
                                if (count($cart) === 0 && count($shirtCart) === 0) {
                                    echo "<h3 class='text-secondary text-center'> No products are added to cart yet <h3>";
                                }
                                foreach ($cart as $c) {
                                    if ($c['category_id'] == $_GET['category_id']) { ?>
                                        <div class="d-flex">
                                            <div class="row justify-content-evenly" style="width:700px;">
                                                <div class="col-3 text-center">
                                                    <?php $photos = explode(',', $c['product_images']);
                                                    if (!empty($photos[0])) : ?>
                                                        <img src="<?php echo htmlspecialchars($photos[0]); ?>" class="rounded" style="max-width: 20rem; max-height: 30rem;" alt="Product Image">
                                                    <?php else : ?>
                                                        <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:170px; height:100px;" alt="No Image Available">
                                                    <?php endif; ?>
                                                    <!-- <img src="<?php //echo $cart[$i]['product_images'] 
                                                                    ?>" alt="" style="width:auto; height:80px;"> -->
                                                </div>
                                                <div class="col-3 ps-5">
                                                    <h6><?php echo $c['product_name'] ?></h6>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <p>
                                                        Size : <?php echo $c['product_size'] ?><br>
                                                        Color : <?php echo $c['product_color'] ?><br>
                                                        Price : <?php echo $c['product_price'] ?>MMK<br>
                                                    </p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <p> Qty <?php echo $c['product_quantity'] ?> </p>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <?php echo $c['total_amount'] ?>MMK
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="./carts.php?dec=<?php echo $i ?>" class="btn" name="dec"><i class="fa-solid fa-delete-left" style="color: #a8a8a8;"></i></a>
                                                <a href="./carts.php?delete=<?php echo $i ?>" class="btn" name="delect"><i class="fa-solid fa-trash-can" style="color: #98999a;"></i></a>
                                            </div>
                                        </div>
                            <?php }
                                }
                            } ?>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-3">
                <div class="card p-3 shadow mt-2 bg-body rounded">
                    <h5 class="card-title">Order Summary</h5>
                    <hr>
                    <div class="card-text">
                        <?php
                        // var_dump($_SESSION['category']);
                        if (isset($_SESSION['shirtCart']) && $_SESSION['shirtCart'] != []) {
                            $sq = 0;
                            $shirtTotal = 0;
                            foreach ($shirtCart as $sc) {
                                $sq = $sq + $sc['qty'];
                                $shirtTotal = ($shirtTotal + $sc['total_price']) * $sq;
                            }
                        ?>
                            <div class="d-flex justify-content-between px-2">
                                <div>
                                    Shirt (<?php echo $sq ?>)
                                </div>
                                <div>
                                    <?php echo $shirtTotal ?>
                                </div>
                            </div>
                        <?php
                        }
                        for ($i = 0; $i < count($cate); $i++) {
                            //var_dump($cate['category_id']);
                            $categories = get_category_by_id($mysqli, $cate[$i]['category_id']);
                            //var_dump($categories);
                            //var_dump($category);
                        ?>
                            <div class="d-flex justify-content-between px-2">
                                <div>
                                    <?php echo $categories['category_name'] ?> (<?php echo $cate[$i]['category_qty'] ?>)
                                </div>
                                <div>
                                    <?php echo $cate[$i]['amount'] ?>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- sometime discount will be include -->
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5>Total</h5>
                            <?php
                            $total = 0;
                            foreach ($cart as $amount) {
                                $total = $total + $amount['total_amount'];
                            }
                            foreach ($shirtCart as $tt) {
                                $total = ($total + $tt['total_price']) * $tt['qty'];
                            }
                            $order_total = ['orderTotal' => $total];
                            $_SESSION['orderTotal'] = $order_total;
                            ?>
                            <h5><?php echo $total ?>MMK</h5>
                        </div>
                    </div>
                    <div class="d-grid">
                        <a class="btn btn-dark" data-bs-toggle="modal" href="#order" role="button">Process
                            to Order</a>
                        <?php
                        require_once("./cart_modal/order.php");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("./Layout/footer.php") ?>
