<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/stickerDb.php');


?>

<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between mb-3">
        <a href="./create.php" class="btn btn-primary">Create&nbsp;New&nbsp;Sticker&nbsp;</a>
    </div>

    <?php if (!empty($products)) : ?>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php foreach ($products as $product) : ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                            <p class="card-text">Product Price: <?php echo htmlspecialchars($product['product_price']); ?></p>
                            <p class="card-text">Product Quantity: <?php echo htmlspecialchars($product['product_quantity']); ?></p>
                            <p class="card-text">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
                            <a href="show.php?id=<?php echo urlencode($product['product_id']); ?>" class="btn btn-primary btn-sm">Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Pagination" class="mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo ($page > 1) ? $page - 1 : '#'; ?>" aria-label="Previous" <?php echo ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo ($page < $total_pages) ? $page + 1 : '#'; ?>" aria-label="Next" <?php echo ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    <?php else : ?>
        <p>No products found.</p>
    <?php endif; ?>

</div>

<?php require_once('../layouts/adminFooter.php'); ?>