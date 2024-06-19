<?php
require_once('../database/index.php');
require_once('../database/userDb.php');

$email = $password = "";
$email_error = $password_error = $role_error = "";


if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    
    if (empty($password)) $password_error = "Password must not be empty";

    $users = get_all_users($mysqli);
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            if (password_verify($password, $user['password'])) {
                if ($user['role'] === "admin") {
                    setcookie("admin", json_encode($user), time() + 3600 * 24 * 7 * 2, '/');
                    header("Location:../admin/users/index.php");
                } else {
                    $role_error = "You are not admin";
                }
            } else {
                $password_error = "Password is incorrect";
            }
        } else {
            if (empty($email)){
                $email_error = "Email must not be empty";
            }else{
                $email_error = "Email is incorrect";
            }
            
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-3">

        <div class="d-flex justify-content-center">
            <div class="card col-4 p-5 mt-5">
                <h2 class="text-center mb-5">Admin Login</h2>
                <?php if ($role_error)
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$role_error</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>"
                ?>
                <form method="post">
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
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary mt-2">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>