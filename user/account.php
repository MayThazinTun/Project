<?php
require_once ("./Layout/header.php");
if (isset($_POST['logout'])) {
    setcookie('user', '', -1, '/');
    header("Location:../signin.php");
    if (isset($_COOKIE['user'])):
        setcookie('user', '', time() - 7000000, '/');
    endif;
}

$cookie_user = null;
if (isset($_COOKIE['user'])) {
    $cookie_user = json_decode($_COOKIE['user'], true);
}
$users = get_user_by_id($mysqli, $cookie_user['id']);
$user = $users->fetch_assoc();

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
                <form>
                    <div class="row mx-5 my-3">
                        <label for="name" class="col-4 form-label fs-4">Name</label>
                        <input type="text" class="col form-control fs-5" value="<?php echo $user['name'] ?>" id="name"
                            name="name">
                    </div>
                    <div class="row mx-5 my-3">
                        <label for="email" class="col-4 form-label fs-4">Email</label>
                        <input type="email" class="col form-control fs-5" value="<?php echo $user['email'] ?>"
                            id="email" name="email">
                    </div>
                    <div class="row mx-5 my-3">
                        <label for="address" class="col-4 form-label fs-4">Address</label>
                        <input type="text" class="col form-control fs-5" value="<?php echo $user['address'] ?>"
                            id="address" name="address">
                    </div>
                    <div class="text-end me-5 my-3">
                        <a class="btn btn-dark" data-bs-toggle="modal" href="#save" role="button">Save Change</a>
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
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-dark" data-bs-toggle="modal"
                                        data-bs-dismiss="modal">Confirm</button>
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