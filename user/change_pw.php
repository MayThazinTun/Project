<?php require_once ("./Layout/header.php");
if (isset($_POST['logout'])) {
    setcookie('user', '', -1, '/');
    header("Location:../signin.php");
    if (isset($_COOKIE['user'])):
        setcookie('user', '', time() - 7000000, '/');
    endif;
}

$current_pw = $new_pw = $confirm_pw = '';
$current_pw_err = $new_pw_err = $confirm_pw_err = '';
$success = $invalid = false;

if (isset($_POST['submit'])) {
    $current_pw = htmlspecialchars($_POST["current_password"]);
    $new_pw = htmlspecialchars($_POST["new_password"]);
    $confirm_pw = htmlspecialchars($_POST["confirm_password"]);

    if (empty($current_pw)) {
        $current_pw_err = "This can't be blank";
    }
    if (empty($new_pw)) {
        $new_pw_err = "This can't be blank";
    }
    if (empty($confirm_pw)) {
        $confirm_pw_err = "This can't be blank";
    }
    if ($new_pw !== $confirm_pw) {
        $confirm_pw_err = "Confirm password must be the same as new password";
    }

    $cookie_user = null;
    if (isset($_COOKIE['user'])) {
        $cookie_user = json_decode($_COOKIE['user'], true);
        // echo '<pre>';
        // var_dump($user);
    }
    if (empty($current_pw_err) && empty($new_pw_err) && empty($confirm_pw_err)) {
        $users = get_user_by_id($mysqli, $cookie_user['id']);
        $user = $users->fetch_assoc();
        // var_dump($user);
        // $current_pw = password_hash($current_pw, PASSWORD_DEFAULT);
        if (password_verify($current_pw, $user['password'])) {
            // echo 'true';
            // exit();
            if (change_pw_by_id($mysqli, $user['id'], $new_pw)) {
                // echo 'true';
                $success = true;
                header("Location:./change_pw.php");
            }
        } else {
            $current_pw_err = "Current password incorrect";
            $invalid = true;
        }
    }
}

?>

<div class="row">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height:92vh">
        <div class="fs-5 ps-3">
            Account
        </div>
        <hr>
        <div class="btn-group-vertical gap-2">
            <a class="btn btn-outline-secondary border-0 text-start ps-1" data-bs-toggle="collapse" href="#myaccount"
                role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-caret-down fa-lg" style="color: #696969;"></i> &nbsp; My Account
            </a>
            <div class="collapse ps-2" id="myaccount" style="width:90%">
                <div class="d-grid gap-2">
                    <a href="./account.php" class="btn btn-outline-dark border-0 text-start ps-4">Profile</a>
                    <a href="./change_pw.php" class="btn btn-outline-dark border-0 text-start ps-4">Change password</a>
                </div>
            </div>
            <a class="btn btn-outline-secondary border-0 text-start ps-1" data-bs-toggle="collapse" href="#information"
                role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-caret-down fa-lg" style="color: #696969;"></i> &nbsp; Information
            </a>
            <div class="collapse ps-2" id="information" style="width:90%">
                <div class="d-grid gap-2">
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Contact Us</a>
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">About Us</a>
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Shop Address</a>
                </div>
            </div>
            <form method="post" class="">
                <button name="logout" class="btn btn-outline-secondary border-0"><i
                        class="fa-solid fa-arrow-right-from-bracket fa-xl" style="color: #616161;"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="col">
        <div class="text-center mt-3">
            <h1>Change Password</h1>
        </div>
        <div class="d-flex justify-content-center">

            <div class="card p-3 m-5" style="width:50%; height:auto;">
                <form method="post">
                    <div class="row mb-3 form-group">
                        <label for="current_password" class="col-4 form-label">Current password</label>
                        <input type="password" class="col form-control me-2" id="current_password"
                            name="current_password">
                            <small class="text-danger text-center"><?php echo $current_pw_err ?></small>
                    </div>
                    <div class="row mb-3 form-group">
                        <label for="new_password" class="col-4 form-label">New Password</label>
                        <input type="password" class="col me-2 form-control" id="new_password" name="new_password">
                        <small class="text-danger text-center"><?php echo $new_pw_err ?></small>
                    </div>
                    <div class="row mb-3 form-group">
                        <label for="confirm_password" class="col-4 form-label">Confirm Password</label>
                        <input type="password" class="col me-2  form-control" id="confirm_password"
                            name="confirm_password">
                            <small class="text-danger text-center"><?php echo $confirm_pw_err ?></small>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark" name="submit">Change Password</button>
                    </div>
                    <?php
                    if ($success)
                        echo '<div class="alert alert-primary">Changing password success!</div>';
                    if ($invalid)
                        echo '<div class="alert alert-danger">Someting invalid!</div>';
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once ("../Layout/footer.php") ?>