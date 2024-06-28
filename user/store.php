<?php require_once ("./Layout/header.php") ?>

<div class="row">
    <div class="col-auto">
        <?php require_once ("./Layout/sidebar.php") ?>
    </div>
    <div class="col">
        <div class="card-content row gap-3">
            <?php
            $products = getAll($mysqli);
            //$products = get_product_by_category_id($mysqli, $_GET['category_id']);
            if (isset($_GET['category_id'])) {
                $products = get_product_by_category_id($mysqli, $_GET['category_id']);
                // $products = $product->fetch_assoc();
            }
            // var_dump($_GET['category_id']);
            // var_dump(get_product_by_category_id($mysqli, $_GET['category_id'])->fetch_assoc());
            while ($product = $products->fetch_assoc()) {
                ?>
                <div class="card col-2 mt-3" style="width:300px; height: auto;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name'] ?></h5>
                        <p class="card-text">Color : <?php //echo $product['product_color'] ?></p>
                        <p class="card-text">Size : <?php //echo $product['product_size'] ?></p>
                        <p class="card-text">Price : <?php echo $product['product_price'] ?></p>
                        <div class="row justify-content-center gap-2 px-2">

                            <button type="button" class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#">
                                Add to cart
                            </button>


                            <?php require_once ("./order.php") ?>
                            <?php require_once ("./buy.php") ?>
                            <?php require_once ("./invoice.php"); ?>
                            <a class="col btn btn-dark" data-bs-toggle="modal" href="#order" role="button"> Order</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>

<?php require_once ("./Layout/footer.php") ?>