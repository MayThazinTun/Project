<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/productDb.php');

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Number of products per page (2 rows * 4 columns)
$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_products = get_total_product_count($mysqli, $search);
// var_dump($total_products);
$total_pages = ceil($total_products / $limit);
// var_dump($total_pages);

$products = get_all_products_paginated($mysqli, $limit, $offset, $search);

?>

<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between mb-3">
        <a href="./create.php" class="btn btn-primary">Create New Product</a>
        <!-- Search Form -->
        <form method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>" style="width: 200px;">
            <button type="submit" class="btn btn-primary me-2">Search</button>
            <a href="index.php" class="btn btn-secondary">Clear</a>
        </form>
    </div>

    <?php
    if (!empty($products)) {
        echo '<div class="row row-cols-1 row-cols-md-4 g-4">';
        foreach ($products as $product) {
            echo '<div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($product['product_name']) . '</h5>
                            <p class="card-text">Product Price: ' . htmlspecialchars($product['product_price']) . '</p>
                            <p class="card-text">Product Quantity: ' . htmlspecialchars($product['product_quantity']) . '</p>
                            <p class="card-text">Category: ' . htmlspecialchars($product['category_name']) . '</p>
                            <a href="show.php?id=' . urlencode($product['product_id']) . '" class="btn btn-primary btn-sm">Details</a>
                        </div>
                    </div>
                </div>';
        }
        echo '</div>';

        // Pagination 
        echo '<nav aria-label="Pagination" class="mt-3">
                <ul class="pagination justify-content-center">';
        if ($page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
        }
        if ($page < $total_pages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        echo '  </ul>
              </nav>';
    } else {
        echo '<p>No products found.</p>';
    }
    ?>
</div>

<?php require_once('../layouts/adminFooter.php'); ?>