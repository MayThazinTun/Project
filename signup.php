<?php
require_once ('./database/index.php');
require_once ("./database/userDb.php");
require_once ("./database/categoryDb.php");
require_once ("./database/productDb.php");
require_once ('./baseUrl.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <link rel="stylesheet" href="./user/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</head>

<body>

    <?php require_once ("./Login/nav.php");
    $user = null;
    if (isset($_COOKIE['user'])) {
        $user = json_decode($_COOKIE['user'], true);
    }
    if ($user) {
        if ($user['role'] === 'admin') {
            header("Location:./admin/users/index.php");
        } else {
            header("Location:./user/index.php");
        }
    }

    $name = $email = $address = $password = $re_password = $role = $check = "";
    $name_err = $email_err = $address_err = $password_err = $re_password_err = $check_err = "";
    $success = $invalid = false;

    if (isset($_POST["submit"])) {
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);
        $address = htmlspecialchars($_POST["address"]);
        $password = htmlspecialchars($_POST["password"]);
        $re_password = htmlspecialchars($_POST["re_password"]);

        if (empty($name)) {
            $name_err = "Name must not be empty";
        }
        if (empty($email))
            $email_err = "Email must not be empty";
        if (empty($address))
            $address_err = "Address must not be empty";
        if (empty($password))
            $password_err = "Password must not be empty";
        if (empty($re_password))
            $re_password_err = "Confirm password must not be empty";
        if ($password !== $re_password)
            $re_password_err = "Confirm password must be the same as password";

        if (!isset($_POST['checkbox']))
            $check_err = "You have to check this";


        if (empty($name_err) && empty($email_err) && empty($address_err) && empty($password_err) && empty($re_password_err) && empty($check_err)) {
            $databaseEmail = get_user_by_email($mysqli, $email);
            if ($databaseEmail['email'] == $email) {
                $email_err = "Email already exists";
            } else {
                $password = password_hash($password,PASSWORD_DEFAULT);
                $photo_path = BASE_URL."/images/avatars/default_avatar3.png";
                if (create_user($mysqli, $name, $email,$address, $password, 'user', $photo_path)) {
                    $success = true;
                    $create = get_user_by_email($mysqli,$email);
                    setcookie("user", json_encode($create), time() + 3600 * 24 * 7 * 2, '/');
                    header("Location: ./user/index.php");
                    $name = $email = $address = $password = $role = $re_password = "";
                } else {
                    $invalid = true;
                }
            }
        }
    }

    ?>

    <div class="container-fluid py-5 "
        style="background: rgb(205,198,214); background: linear-gradient(90deg, rgba(205,198,214,1) 0%, rgba(204,126,219,1) 15%, rgba(235,169,75,1) 31%, rgba(163,233,27,1) 46%, rgba(90,227,92,1) 57%, rgba(73,240,132,1) 70%, rgba(48,209,183,1) 84%, rgba(110,167,201,1) 96%);">
        <div class="card my-5 mx-3 border-primary rounded-5 px-3 py-1"
            style="background: rgb(238,174,202); background: radial-gradient(circle, rgba(238,174,202,0.4962359943977591) 0%, rgba(148,187,233,0.5) 100%);">
            <div class="row text-center">
                <div class="col-6 align-self-center">
                    <img src="./images/Logo1.png" class="border rounded-circle border-2 border-white"
                        style="width: 300px;height: 300px;">
                </div>

                <div class="col-6 align-self-center bg-white border rounded-end rounded-5 p-0">
                    <div class="mx-3 my-3">
                        <h2 class="fst-italic text-success">Create an Account</h2>
                        <div class="" style="padding-left:40%;">
                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                                type="module"></script>

                            <dotlottie-player
                                src="https://lottie.host/470b48f3-3ef7-4f60-974b-e860436c5abd/zz4iOzJzia.json"
                                background="transparent" speed="1" style="width: 100px; height: 100px;" loop
                                autoplay></dotlottie-player>
                        </div>
                        <h5 class="fst-italic  text-success">Sing up to Continue</h5>
                    </div>
                    <form method="post">
                        <div class="form-group row mb-3 justify-content-center">
                            <div class="col-4 text-start fs-5">
                                <label for="username" class="form-label">Username</label>
                            </div>

                            <div class="col-6">
                                <input type="text" class="form-control" id="username" name="name"
                                    value="<?php echo $name ?>">
                                <small class="text-danger"><?php echo $name_err ?></small>
                            </div>
                        </div>
                        <div class="form-group row mb-3 justify-content-center">
                            <div class="col-4 text-start fs-5">
                                <label for="email" class="form-label">Email</label>
                            </div>

                            <div class="col-6">
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $email ?>">
                                <small class="text-danger"><?php echo $email_err ?></small>
                            </div>
                        </div>
                        <div class="form-group row mb-3 justify-content-center">
                            <div class="col-4 text-start fs-5">
                                <label for="address" class="form-label">Address</label>
                            </div>

                            <div class="col-6">
                                <input type="text" class="form-control" id="address" name="address"
                                    value="<?php echo $address ?>">
                                <small class="text-danger"><?php echo $address_err ?></small>
                            </div>
                        </div>
                        <div class="form-group row mb-3 justify-content-center">
                            <div class="col-4 text-start fs-5">
                                <label for="passowrd" class="form-label">Password</label>
                            </div>

                            <div class="col-6">
                                <input type="password" class="form-control" id="password" name="password"
                                    value="<?php echo $password ?>">
                                <small class="text-danger"><?php echo $password_err ?></small>
                            </div>
                        </div>
                        <div class="form-group row mb-3 justify-content-center">
                            <div class="col-4 text-start fs-5">
                                <label for="c_password" class="form-label">Re-password</label>
                            </div>

                            <div class="col-6 text-start">
                                <input type="password" class="form-control" id="c_password" name="re_password"
                                    value="<?php echo $re_password ?>">
                                <small class="text-secondary">Confirm password</small>
                                <small class="text-danger"><?php echo $re_password_err ?></small>
                            </div>

                        </div>
                        <div>
                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                        <div class="form-check p-0 badge text-wrap text-dark mt-3">
                            <input class="form-check-input" type="checkbox" name="checkbox" id="flexCheckDefault"
                                value="1">
                            <label class="form-check-label" for="flexCheckDefault">
                                I have agreed to the terms and conditions.
                            </label>
                            <small class="text-danger"><?php echo $check_err ?></small>
                        </div>
                    </form>
                    <?php
                    if ($success)
                        echo '<div class="alert alert-primary">Registeration success!</div>';
                    if ($invalid)
                        echo '<div class="alert alert-danger">Someting invalid!</div>';
                    ?>
                    <p>
                        Already have an account?<a href="./signin.php">Sing in</a>
                    </p>
                </div>

            </div>

        </div>

    </div>

    <?php require_once ("./Login/footer.php") ?>