<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/productDb.php');

// Delete
if (isset($_GET['deleted_id'])) {
    delete_product_by_id($mysqli, $_GET['deleted_id']);
    header('location: index.php');
    exit;
}

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Number of products per page (2 rows * 4 columns)
$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_products = get_total_product_count($mysqli, $search);
$total_pages = ceil($total_products / $limit);

$products = get_all_products_paginated($mysqli, $limit, $offset, $search);

?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between mb-3">
        <a href="./create.php" class="btn btn-primary">Create&nbsp;New&nbsp;Product&nbsp;<i class="fa-solid fa-store"></i></a>
        <!-- Search Form -->
        <form method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>" style="width: 150px;">
            <button type="submit" class="btn btn-primary me-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            <a href="index.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i></a>
        </form>
    </div>

    <?php if (!empty($products)) : ?>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php foreach ($products as $product) : ?>
                <div class="col">
                    <div class="card me-3 mb-2" style="width: 14rem; height:fit-content">
                        <?php foreach (explode(",", $product['product_images']) as $photo) : ?>
                            <?php if (!empty($photo)) : 
                                 $dir ="../../images/All/products/".$photo;
                                  ?>
                                <img src="<?php echo htmlspecialchars($dir); ?>" class="card-img-top" style="max-width: 14rem; max-height: 14rem;">
                            <?php else : ?>
                                <img src=<?php echo "../../images/All/default_image.jpg"?> class="card-img-top" style="max-width: 14rem; max-height: 14rem;" alt="No Image Available">
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <span><?php echo $product['product_name'] ?></span>
                                </li>
                                <li class="list-group-item">
                                    Category&nbsp;: <span><?php echo htmlspecialchars($product['category_name']); ?></span>
                                </li>
                                <li class="list-group-item">
                                    Price&nbsp;: <span><?php echo $product['product_price'] ?></span>
                                </li>
                                <li class="list-group-item">
                                    Stock&nbsp;: <span><?php echo $product['product_quantity'] ?></span>
                                </li>
                            </ul>
                            <div class="text-end">
                                <a href="view.php?view_id=<?php echo $product['product_id'] ?>"><i class="btn btn-primary fa-solid fa-file-invoice"></i></a>
                                <a href="edit.php?updated_id=<?php echo $product['product_id'] ?>"><i class="btn btn-warning fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?deleted_id=<?php echo $product['product_id'] ?>"><i class="btn btn-danger fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else : ?>
        <p>No products found.</p>
    <?php endif; ?>

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
</div>

</div>

<?php require_once('../layouts/adminFooter.php'); ?>