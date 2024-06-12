<?php require_once('../../database/userDb.php'); ?>
<?php require_once('../layouts/adminHeader.php');
if (isset($_GET['deleted_id'])) {
    delete_user($mysqli, $_GET['deleted_id']);
    header('location: index.php');
    exit;
}

?>

<div class="container mt-2">
    <h1 class="text-center">Users Information</h1>
    <a href="./create.php" class="btn btn-primary mb-2">Create User</a>
    <table class="table table-striped table-bordered">
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
            <?php
            $users = get_all_users($mysqli);
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . $user['name'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td>" . $user['role'] . "</td>";
                echo "<th>";
                echo "<a href='edit.php?updated_id=" . $user['id'] . "' class='btn btn-warning me-2 btn-sm'>Edit</a>";
                echo "<a href='index.php?deleted_id=" . $user['id'] . "' class='btn btn-danger btn-sm'>Delete</a>";
                echo "</th>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php require_once('../layouts/adminFooter.php'); ?>