<?php require_once('../../database/userDb.php'); ?>
<?php require_once('../layouts/adminHeader.php');
if (isset($_GET['deleted_id'])) {
    delete_user($mysqli, $_GET['deleted_id']);
    header('location: index.php');
    exit;
}


// Page Limit for Users
$limit = 6;

// Page Number where we are
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Value from input field
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Offset for pagination 
$offset = ($page - 1) * $limit;

$total_users = get_total_user_count($mysqli, $search);

$total_pages = ceil($total_users / $limit);

$users = get_all_users_pagination($mysqli, $limit, $offset, $search);

// var_dump("Page ".$page,"Search ".$search,
//         "Offset ".$offset,"Total Users ".$total_users,
//         "Total Pages ".$total_pages);


?>

<div class="container mt-2">
    <h1 class="text-center">Users Information</h1>
    <div class="d-flex justify-content-between mb-2">
        <a href="./create.php" class="btn btn-primary">Create User</a>
        <!-- Search Form -->
        <form method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>" style="width: 200px;">
            <button type="submit" class="btn btn-primary me-2">Search</button>
            <a href="index.php" class="btn btn-secondary">Clear</a>
        </form>
    </div>
    <table class="table table-striped table-bordered my-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                        <a href='edit.php?updated_id=<?php echo $user['id']; ?>' class='btn btn-warning me-2 btn-sm'>Edit</a>
                        <a href='index.php?deleted_id=<?php echo $user['id']; ?>' class='btn btn-danger btn-sm'>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

    <!-- Pagination -->
    <div class="container">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1 ?>&&search=<?php echo htmlspecialchars($search); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i ?>&search=<?php echo htmlspecialchars($search) ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $total_pages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1 ?>&&search=<?php echo htmlspecialchars($search); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

</div>

<?php require_once('../layouts/adminFooter.php'); ?>