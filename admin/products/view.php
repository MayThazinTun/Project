<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/productDb.php');

$product_id = isset($_GET['view_id']) ? (int)$_GET['view_id'] : null;
$product = null;

if ($product_id) {
    $product = get_product_by_id($mysqli, $product_id);
}
?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="d-flex justify-content-center">
            <div class="col-6">
                <form action="" method="post">
                    <h3 class="text-center">Product View</h3>

                    <?php if ($product) : ?>
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="col">
                                <div class="card">
                                    <div class="col-md-4">
                                        <?php $photos = explode(',', $product['product_images']); ?>
                                        <?php if (!empty($photos[0])) : ?>
                                            <img src="<?php echo htmlspecialchars($photos[0]); ?>" class="img-fluid rounded-start" alt="Product Image" style="max-width: 100%; height: auto; object-fit: cover; max-height: 200px;">
                                        <?php else : ?>
                                            <img src="default_image.jpg" class="img-fluid rounded-start" alt="No Image Available" style="max-width: 100%; height: auto; object-fit: cover; max-height: 200px;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($product['product_description']); ?></p>
                                        <p class="card-text"><small class="text-body-secondary">Price: $<?php echo htmlspecialchars($product['product_price']); ?></small></p>
                                        <p class="card-text"><small class="text-body-secondary">Category: <?php echo htmlspecialchars($product['category_name']); ?></small></p>
                                        <p class="card-text"><small class="text-body-secondary">Stock: <?php echo htmlspecialchars($product['product_quantity']); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        <?php else : ?>
            <p class="text-center">Product not found.</p>
        <?php endif; ?>

        </form>
        </div>
    </div>

</div>
</div>

<?php require_once('../layouts/adminFooter.php'); ?>