<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/categoryDb.php');

$category_name = "";
$category_name_error = "";
$success = "";
$invalid = "";
if (isset($_GET['success'])) {
    $success = $_GET['success'];
}

if (isset($_GET['invalid'])) {
    $invalid = $_GET['invalid'];
}

if (isset($_POST['submit'])) {
    $category_name = $_POST['category_name'];
    if (empty($category_name)) {
        $category_name_error = "Category name is required";
    } else {
        if (create_category($mysqli, $category_name)) {
            $success = "Category created successfully";
            $category_name = "";
        } else {
            $invalid = "Something went wrong";
        }
    }
}

if (isset($_GET['deleted_id'])) {
    $category_id = $_GET['deleted_id'];
    if (delete_category_by_id($mysqli, $category_id) === true) {
        header('location: index.php?success=Category has been deleted');
    } else {
        header('location: index.php?invalid=Something went wrong');
    }
}

if (isset($_GET['updated_id'])) {
    $category_id = $_GET['updated_id'];
    $category = get_category_by_id($mysqli, $category_id);
    $category_name = $category['category_name'];
    if (isset($_POST['update'])) {
        $category_name = $_POST['category_name'];
        if (update_category_by_id($mysqli, $category_id, $category_name)) {
            header('location: index.php?success=Category has been updated');
        } else {
            header('location: index.php?invalid=Something went wrong');
        }
    }
}


// Category Pagination

// Page Limit for Users
$limit = 5;

// Page Number where we are
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Offset for pagination 
$offset = ($page - 1) * $limit;

$total_categories = get_total_category_count($mysqli);

// Calculate total pages
$total_pages = ceil($total_categories / $limit);

$categories = get_all_categories_pagination($mysqli, $limit, $offset);

// var_dump(
//     "Page " . $page,
//     "Offset " . $offset,
//     "Total Category " . $total_categories,
//     "Total Pages " . $total_pages
// );

?>

<div class="container-fluid mt-3">
    <div class="row">
        <div class="d-flex justify-content-center">
            <div class="col-6">
                <form action="" method="post">
                    <h3 class="text-center">Categories</h3>
                    <?php if ($category_name_error)
                        echo    "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    <strong>$category_name_error</strong>
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
                        <label for="category_name" class="form-label mb-3">Category name</label>
                        <div class="col">
                            <input type="text" name="category_name" value="<?php echo $category_name ?>" class="form-control" id="category_name">
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
                    <?php foreach ($categories as $category) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo $category['category_name'] ?></span>
                            <div>
                                <a href="index.php?updated_id=<?php echo $category['category_id'] ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?deleted_id=<?php echo $category['category_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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