<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/stickerDb.php');
if (isset($_GET['deleted_id'])) {
    delete_sticker_by_id($mysqli, $_GET['deleted_id']);
    header('location: index.php');
    exit;
}

// Page Limit for Sticker
$limit = 4;

// Page Number where we are
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Offset for pagination 
$offset = ($page - 1) * $limit;

$total_stickers = get_total_stickers_count($mysqli);

// Calculate total pages
$total_pages = ceil($total_stickers / $limit);

$stickers = get_all_stickers_pagination($mysqli, $limit, $offset);


?>

<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between mb-3">
        <a href="./create.php" class="btn btn-primary">Create&nbsp;New&nbsp;Sticker&nbsp;</a>
    </div>
    <div class="row">
        <?php if (!empty($stickers)) : ?>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php foreach ($stickers as $sticker) : ?>
                    <div class="col">
                        <div class="card me-3 mb-3" style="width: 14rem; height:fit-content">
                            <?php foreach (explode(",", $sticker['sticker_images']) as $photo) : 
                                 $dir ="../../images/All/stickers/".$photo;
                                 ?>
                                <img src="<?php echo $dir; ?>" alt="" class="card-img-top" style="max-width: 14rem; max-height: 14rem;">
                            <?php endforeach; ?>
                            <div class="card-body">
                                <h5 class="card-title">Price&nbsp;: <span><?php echo $sticker['sticker_price'] ?></span></h5>
                            </div>
                            <div class="card-body text-end">
                                <a href="edit.php?updated_id=<?php echo $sticker['sticker_id'] ?>"><i class="btn btn-warning fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?deleted_id=<?php echo $sticker['sticker_id'] ?>"><i class="btn btn-danger fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <p>No stickers found.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="container mt-3">
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