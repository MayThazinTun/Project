<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/colorDb.php');

$color_name = "";
$color_name_error = "";
$success = "";
$invalid = "";
if (isset($_GET['success'])) {
    $success = $_GET['success'];
}

if (isset($_GET['invalid'])) {
    $invalid = $_GET['invalid'];
}

if (isset($_POST['submit'])) {
    $color_name = $_POST['color_name'];
    if (empty($color_name)) {
        $color_name_error = "Color is required";
    } else {
        if ($color_name) {
            createColors($mysqli, $color_name);
            $success = "Color created successfully";
            $color_name = "";
        } else {
            $invalid = "Something went wrong";
        }
    }
}

if (isset($_GET['deleted_id'])) {
    $color_id = $_GET['deleted_id'];
    if (deleteColor($mysqli, $color_id) === true) {
        header('location: index.php?success=color has been deleted');
    } else {
        header('location: index.php?invalid=Something went wrong');
    }
}

if (isset($_GET['updated_id'])) {
    $color_id = $_GET['updated_id'];
    $color = getColorById($mysqli, $color_id);
    $color_name = $color['color_name'];
    if (isset($_POST['update'])) {
        $color_name = $_POST['color_name'];
        if (updateColor($mysqli, $color_id, $color_name)) {
            header('location: index.php?success=color has been updated');
        } else {
            header('location: index.php?invalid=Something went wrong');
        }
    }
}


// color Pagination

// Page Limit for Users
$limit = 5;

// Page Number where we are
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Offset for pagination 
$offset = ($page - 1) * $limit;

$total_categories = get_total_colors_count($mysqli);

// Calculate total pages
$total_pages = ceil($total_categories / $limit);

$categories = get_all_colors_pagination($mysqli, $limit, $offset);

?>

<div class="container-fluid mt-3">
    <div class="row">
        <div class="d-flex justify-content-center">
            <div class="col-6">
                <form action="" method="post">
                    <h3 class="text-center">Colors</h3>
                    <?php if ($color_name_error)
                        echo    "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    <strong>$color_name_error</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>"
                    ?>
                    <?php if ($success)
                        echo    "<div class='alert alert-primary alert-dismissible fade show' role='alert'>
                                    <strong>$success</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>"
                    ?>
                    <?php if ($invalid)
                        echo    "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>$invalid</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>"
                    ?>
                    <div class="my-4 row align-items-center">
                        <label for="color_name" class="form-label mb-3">Color name</label>
                        <div class="col">
                            <input type="text" name="color_name" value="<?php echo $color_name ?>" class="form-control" id="color_name">
                        </div>
                        <div class="col-auto">
                            <?php if (isset($_GET['updated_id'])) : ?>
                                <button type="submit" name="update" class="btn btn-primary">Update&nbsp;<i class="fa-solid fa-circle-plus"></i></button>
                                <a href="index.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i></a>
                            <?php else : ?>
                                <button type="submit" name="submit" class="btn btn-primary">Create&nbsp;<i class="fa-solid fa-circle-plus"></i></button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
                <ul class="list-group">
                    <?php foreach ($categories as $color) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo $color['color_name'] ?></span>
                            <div>
                                <a href="index.php?updated_id=<?php echo $color['color_id'] ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?deleted_id=<?php echo $color['color_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
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
        </div>

    </div>
</div>

<?php require_once('../layouts/adminFooter.php'); ?>