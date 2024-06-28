<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/itemDb.php');

$item_id = isset($_GET['view_id']) ? (int)$_GET['view_id'] : null;
$item = null;

if ($item_id) {
    $item = get_item_by_id($mysqli, $item_id);
}
?>

<div class="container mt-5">
    <h1 class="text-center">Item Details</h1>

    <?php if ($product) : ?>
        <div class="container row">
            <!-- <div class="col-4">
                <?php //$photos = explode(',', $product['product_images']); ?>
                <?php //if (!empty($photos[0])) : ?>
                    <img src="<?php //echo htmlspecialchars($photos[0]); ?>" class="rounded" style="max-width: 20rem; max-height: 50rem;" alt="Product Image">
                <?php //else : ?>
                    <img src="../../images/All/default_image.jpg" class="" style="max-width: 20rem; max-height: 50rem;" alt="No Image Available">
                <?php //endif; ?>
            </div> -->
            <div class="col-8 d-flex text-center">
                <div class="card-body">
                    <ul class="list-group">
                        <!-- <li class="list-group-item">
                            <h3 class="card-title">Name : <?php //echo htmlspecialchars($product['product_name']); ?></h3>
                        </li> -->
                        <li class="list-group-item">
                            <h5 class="card-title">Category: <?php echo htmlspecialchars($item['category_name']); ?></h5>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Type: <?php echo htmlspecialchars($item['type_price']); ?></h5>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Color: <?php echo htmlspecialchars($item['color_name']); ?></h5>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Size: <?php echo htmlspecialchars($item['size']); ?></h5>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Sticker: <?php echo htmlspecialchars($item['sticker_price']); ?></h5>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Stock: <?php echo htmlspecialchars($item['item_quantity']); ?></h5>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Price: <?php echo htmlspecialchars($item['item_price']); ?></h5>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Description: <?php echo htmlspecialchars($item['item_note']); ?></h5>
                        </li>
                    </ul>
                    <div class="mt-3">
                        <a href="edit.php?updated_id=<?php echo $item['item_id'] ?>"><i class="btn btn-warning fa-solid fa-pen-to-square"></i></a>
                        <a href="./index.php"><i class="fa-solid fa-backward btn btn-secondary"></i></a>
                        <a href="index.php?deleted_id=<?php echo $item['item_id'] ?>"><i class="btn btn-danger fa-solid fa-trash"></i></a>
                    </div>

                </div>
            </div>
        </div>
    <?php else : ?>
        <p class="text-center">Item not found.</p>
    <?php endif; ?>

</div>
</div>

<?php require_once('../layouts/adminFooter.php'); ?>