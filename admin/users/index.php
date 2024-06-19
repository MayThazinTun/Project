<?php require_once('../../database/userDb.php'); ?>
<?php require_once('../layouts/adminHeader.php');
if (isset($_GET['deleted_id'])) {
    delete_user($mysqli, $_GET['deleted_id']);
    header('location: index.php');
    exit;
}


// Page Limit for Users
$limit = 5;

// Page Number where we are
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Value from input field
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Offset for pagination 
$offset = ($page - 1) * $limit;

$total_users = get_total_user_count($mysqli, $search);

$total_pages = ceil($total_users / $limit);

$users = get_all_users_pagination($mysqli, $limit, $offset, $search);

?>

<div class="container mt-2">
    <h1 class="text-center">Users Information</h1>
    <div class="d-flex justify-content-between mb-2">
        <a href="./create.php" class="btn btn-primary">Create&nbsp;New&nbsp;<i class="fas fa-user-plus"></i></a>
        <!-- Search Form -->
        <form method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>" style="width: 150px;">
            <button type="submit" class="btn btn-primary me-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            <a href="index.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i></a>
        </form>
    </div>
    <table class="table table-striped table-bordered my-4 text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Images</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ID = 1;
            foreach ($users as $user) : ?>
                <tr>
                    <td class="align-middle"><?php echo $ID++ ?></td>
                    <td class="align-middle"><?php echo $user['name']; ?></td>
                    <td class="align-middle"><?php echo $user['email']; ?></td>
                    <td class="align-middle"><?php echo $user['role']; ?></td>
                    <td class="align-middle">
                        <?php foreach (explode(",", $user['images']) as $photo) : ?>
                            <img src="<?php echo $photo; ?>" alt="" class="img-fluid rounded-circle mx-auto d-block" style="max-width: 60px; max-height: 60px;">
                        <?php endforeach; ?>
                    </td>
                    <td class="align-middle">
                        <a href='edit.php?updated_id=<?php echo $user['id']; ?>' class='btn btn-warning me-2'><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href='index.php?deleted_id=<?php echo $user['id']; ?>' class='btn btn-danger'><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
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