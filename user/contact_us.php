<?php
require_once("../database/index.php");
require_once('../baseUrl.php');
require_once('../database/auth_user.php');
require_once('../database/userDb.php');
if (isset($_POST['logout'])) {
    setcookie('user', '', -1, '/');
    header("Location:../signin.php");
    if (isset($_COOKIE['user'])):
        setcookie('user', '', time() - 7000000, '/');
    endif;
    session_destroy();
}
require_once("./Layout/header.php");


?>

<div class="row">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow" style="width: 200px; height:92vh">
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
            <a class="btn btn-outline-secondary border-0 text-start ps-1 ps-3" role="button" href="./contact_us.php">
                Contact us
            </a>
            <!-- <div class="collapse ps-2" id="information" style="width:90%">
                <div class="d-grid gap-2">
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Contact Us</a>
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">About Us</a>
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Shop Address</a>
                </div>
            </div> -->
            <form method="post" class="">
                <button name="logout" class="btn btn-outline-secondary border-0"><i
                        class="fa-solid fa-arrow-right-from-bracket fa-xl" style="color: #616161;"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="col"
        style="background: rgb(255, 165, 8);
    background: linear-gradient(90deg, rgba(255, 165, 8, 1) 17%, rgba(33, 143, 171, 1) 48%, rgba(140, 7, 241, 1) 81%);">
        <div class="text-center text-white mt-3">
            <h1>Contact us</h1>
        </div>
        <div class="d-flex justify-content-center">
            <div class="card p-3 m-5 shadow" style="width:50%; height:auto; background: rgb(238,174,202); background: radial-gradient(circle, rgba(238,174,202,0.4962359943977591) 0%, rgba(148,187,233,0.5) 100%);">
                <div class="text-center">
                    <img src="../images/Logo1.png" class="border rounded-circle border-2 border-white"
                        style="width: 150px; height:150px;">
                </div>
                <div style="margin-left: 100px;">
                    <p class="fs-4"> <i class="fa-solid fa-phone" style="color: #000000;"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +959 - 123456789 </p>
                    <p class="fs-4"> <i class="fa-solid fa-envelope" style="color: #000000;"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; teeworldmyanmar@gmail.com </p>
                    <p class="fs-4"> <i class="fa-solid fa-location-dot" style="color: #000000;"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yangon,Myanmar </p>
                </div>
            </div>
        </div>
    </div>

    <?php require_once("./Layout/footer.php") ?>