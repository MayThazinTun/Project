// Start your script
<?php require_once('../layouts/adminHeader.php');
require_once('../../database/sizeDb.php');
if (isset($_GET['deleted_id'])) {
    deleteSizeById($mysqli, $_GET['deleted_id']);
    header('location: index.php');
    exit;
}

// Page Limit for Sizes
$limit = 8;

// Page Number where we are
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Offset for pagination
$offset = ($page - 1) * $limit;

$total_sizes = get_total_sizes_count($mysqli);

$total_pages = ceil($total_sizes / $limit);

$newSize = get_all_sizes_pagination($mysqli, $limit, $offset);

?>
<div class="container mt-2">
    <h1 class="text-center">Sizes</h1>
    <div class="d-flex justify-content-between mb-2">
        <a href="./create.php" class="btn btn-primary">Create&nbsp;New&nbsp;</a>
    </div>
    <table class="table table-striped table-bordered my-4 text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Size</th>
                <th scope="col">Size Price</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($newSize as $size) : ?>
                <tr>
                    <td class="align-middle"><?php echo $i++ ?></td>
                    <td class="align-middle"><?php echo $size['size']; ?></td>
                    <td class="align-middle"><?php echo $size['size_price']; ?></td>
                    <td class="align-middle">
                        <a href='edit.php?updated_id=<?php echo $size['size_id']; ?>' class='btn btn-warning me-2'><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href='index.php?deleted_id=<?php echo $size['size_id']; ?>' class='btn btn-danger'><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php  endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="container">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="<?php if ($page > 1) echo '?page=' . ($page - 1);
                                                else echo '#'; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="<?php if ($page < $total_pages) echo '?page=' . ($page + 1);
                                                else echo '#'; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php require_once('../layouts/adminFooter.php'); ?>