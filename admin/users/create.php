<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/userDb.php');

$name = $email = $password = $role = "";
$name_error = $email_error = $password_error = $role_error = "";

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $role = htmlspecialchars($_POST["role"]);
    if (empty($name)) $name_error = "Name must not be empty";
    if (empty($email)) $email_error = "Email must not be empty";
    if (empty($password)) $password_error = "Password must not be empty";
    if (empty($role)) $role_error = "Role must not be empty";

    if (empty($name_error) && empty($email_error) && empty($password_error) && empty($role_error)) {
        $databaseEmail = get_user_by_email($mysqli, $email);
        if ($databaseEmail['email'] == $email) {
            $email_error = "Email already exists";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            if (create_user($mysqli, $name, $email, $password, $role)) {
                header("Location: index.php");
                $name = $email = $password = $role = "";
            } else {
                $invalid = "Something went wrong";
            }
        }
    }
}

?>

<div class="container mt-2">
    <h1 class="text-center my-4">Create New User</h1>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-5">
            <form method="post">
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="name" class="form-label">Name</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="name" class="form-control" value="<?php echo $name ?>" id="name">
                        <small class="text-danger"><?php echo $name_error ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="col-8">
                        <input type="email" name="email" class="form-control" value="<?php echo $email ?>" id="email">
                        <small class="text-danger"><?php echo $email_error ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="col-8">
                        <input type="password" name="password" class="form-control" value="<?php echo $password ?>" id="password">
                        <small class="text-danger"><?php echo $password_error ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="role" class="form-label">Role</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select" name="role">
                            <option selected value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <small class="text-danger"><?php echo $role_error ?></small>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <button type="submit" name="submit" class="btn btn-primary">Create</button>
                    <a href="./index.php" class="btn btn-warning">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

<?php require_once('../layouts/adminFooter.php'); ?>