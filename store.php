<?php require_once ("./Login/header.php");
$user = null;
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
}
if ($user) {
    if ($user['role'] === 'admin') {
        header("Location:./admin/users/index.php");
    } else {
        header("Location:./user/index.php");
    }
}
?>

<div class="row">
    <div class="col-auto">
        <?php require_once ("./Login/sidebar.php") ?>
    </div>
    <div class="col overflow-auto" style="height:100vh;">
        <div>
            <?php if (isset($_GET['category_id'])) {
                $category = get_category_by_id($mysqli, $_GET['category_id']);
                ?>
                <h1> <?php echo $category['category_name'] ?> </h1>
            <?php } else { ?>
                <h1> All </h1>
            <?php } ?>
            <hr>
        </div>
        <div class="card-content row gap-3">
            <?php
            //Product by category
            $products = getAll($mysqli);
            if (isset($_GET['category_id'])) {
                $products = get_product_by_category_id($mysqli, $_GET['category_id']);
            }
            if ($products) {
                while ($product = $products->fetch_assoc()) {
                    ?>
                    <div class="card col-2 ms-5 mt-3 p-1 mb-3" style="width:280px; height: auto;">
                        <?php $photos = explode(',', $product['product_images']);
                        if (!empty($photos[0])): ?>
                            <img src="<?php echo htmlspecialchars($photos[0]); ?>" class="rounded"
                                style="max-width: 20rem; max-height: 30rem;" alt="Product Image">
                        <?php else: ?>
                            <img src=<?php echo "./images/All/default_image.jpg" ?> class="rounded"
                                style="width:270px; height:150px;" alt="No Image Available">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['product_name'] ?></h5>
                            <p class="card-text">
                                Color : <?php echo $product['product_color'] ?> <br>
                                Size : <?php echo $product['product_size'] ?> <br>
                                Price : <?php echo $product['product_price'] ?>
                            </p>

                            <div class="row justify-content-center gap-2 px-2">
                                <!-- Button trigger modal -->
                                <button type="button" class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">
                                    Add to cart
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                You need to login first!
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <a href="./Register/signin.php" class="btn btn-dark">OK</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">Order</a>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>

    <?php require_once ("./Login/footer.php") ?>