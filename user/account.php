<?php
require_once ("./Layout/header.php");
if (isset($_POST['logout'])) {
    setcookie('user', '', -1, '/');
    header("Location:../signin.php");
    if (isset($_COOKIE['user'])):
        setcookie('user', '', time() - 7000000, '/');
    endif;
}

$name = $email = $address = $password = "";
$name_err = $email_err = $address_err = $password_err = "";
$success = $invalid = false;

$cookie_user = null;
if (isset($_COOKIE['user'])) {
    $cookie_user = json_decode($_COOKIE['user'], true);
}

$id = $cookie_user['id'];
$users = get_user_by_id($mysqli, $id);
$user = $users->fetch_assoc();
$name = $user['name'];
$email = $user['email'];
$address = $user['address'];

if (isset($_GET['update_id'])) {

    if (isset($_POST['update'])) {
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);
        $address = htmlspecialchars($_POST["address"]);
        $password = htmlspecialchars($_POST["password"]);

        if (empty($name))
            $name_err = "Name must not be blank";
        if (empty($email))
            $email_err = "Email must not be blank";
        if (empty($address))
            $address_err = "Address must not be blank";
        if (empty($password))
            $password_err = "Enter password";

        if (empty($name_err) && empty($email_err) && empty($address_err) && empty($password_err)) {
            if (password_verify($password, $user['password'])) {
                $update = update_user_by_id($mysqli, $id, $name, $email, $address, $password, 'user', $user['images']);
                if ($update) {
                    $success = true;
                    echo $success;
                    header("Location: ../user/account.php");
                    // var_dump("updated"); die();
                } else {
                    $invalid = true;
                }
            } else {
                $password_err = "Password incorrect";
                $invalid = true;
            }
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
        <div class="fs-1 text-center">
            Your Profile
        </div>
        <div class="d-flex justify-content-center">
            <div class="card mt-3" style="width:60%;">
                <div class="text-center">
                    <img src="<?php echo $user['images'] ?>" class="m-3 rounded-circle"
                        style="width: 150px; height: 150px;">

                </div>
                <form method="post">
                    <?php
                    $disabled = null;
                    if (!isset($_GET['update_id'])) {
                        $disabled = 'disabled';
                    } ?>
                    <div class="row mx-5 my-3">
                        <label for="name" class="col-4 form-label fs-4">Name</label>
                        <input type="text" class="col form-control fs-5" value="<?php echo $name ?>" id="name"
                            name="name" <?php echo $disabled ?>>
                    </div>
                    <div class="row mx-5 my-3">
                        <label for="email" class="col-4 form-label fs-4">Email</label>
                        <input type="email" class="col form-control fs-5" value="<?php echo $email ?>" id="email"
                            name="email" <?php echo $disabled ?>>
                    </div>
                    <div class="row mx-5 my-3">
                        <label for="address" class="col-4 form-label fs-4">Address</label>
                        <input type="text" class="col form-control fs-5" value="<?php echo $address ?>" id="address"
                            name="address" <?php echo $disabled ?>>
                    </div>
                    <div class="text-end me-5 my-3">
                        <?php if (isset($_GET['update_id'])) { ?>
                            <a class="btn btn-dark" data-bs-toggle="modal" href="#save" role="button">Save
                                Change</a>
                            <a type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                href="../user/account.php">Cancel</a>
                        <?php } else { ?>
                            <a class="btn btn-dark" href="../user/account.php?update_id=<?php echo $id ?>"
                                role="button">Edit Profile</a>
                        <?php } ?>
                    </div>
                    <div class="modal fade" id="save" aria-hidden="true" aria-labelledby="save" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-4" id="order">Enter Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mx-3 my-3">
                                        <label for="password" class="col-4 form-label">Enter password</label>
                                        <input type="password" class="col form-control" id="password" name="password">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-dismiss="modal"
                                        name="update">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="">

                </div>
            </div>
        </div>
    </div>

    <?php require_once ("./Layout/footer.php") ?>