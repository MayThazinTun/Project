<?php require_once ("./Layout/header.php") ?>

<div class="row">
    <div class="col-auto">
        <?php require_once ("./Layout/sidebar.php") ?>
    </div>
    <div class="col">
        <?php
        $products = getAll($mysqli);
        if (isset($_GET['$category_id'])) {
            $products = get_product_by_category_id($mysqli, $_GET['category_id']);
        }
        while ($products) {
            ?>
            <div class="card mt-3" style="width:300px; height: auto;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['product_name'] ?></h5>
                    <p class="card-text">Color : <?php echo $product['product_color'] ?></p>
                    <p class="card-text">Size : <?php echo $product['product_size'] ?></p>
                    <p class="card-text">Price : <?php echo $product['product_price'] ?></p>
                    <div class="row justify-content-center gap-2 px-2">
                        <!-- Button trigger modal -->
                        <button type="button" class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">
                            Add to cart
                        </button>

                        <!-- Modal -->
                        <?php require_once ("./order.php") ?>
                        <?php require_once ("./buy.php") ?>
                        <?php require_once ("./invoice.php"); ?>
                        <a class="btn btn-dark" data-bs-toggle="modal" href="#order" role="button">Process
                            to Order</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php require_once ("./Layout/footer.php") ?>