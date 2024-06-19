<?php require_once ("../Layout/header.php");
if(isset($_POST['logout'])){
    setcookie('user', '', -1, '/');
    header("Location:../signin.php"); 
    if(isset($_COOKIE['user'])):
        setcookie('user', '', time()-7000000, '/');
    endif;
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
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Profile</a>
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Profile</a>
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Profile</a>
                </div>
            </div>
            <a class="btn btn-outline-secondary border-0 text-start ps-1" data-bs-toggle="collapse"
                href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-caret-down fa-lg" style="color: #696969;"></i> &nbsp; Information
            </a>
            <div class="collapse" id="collapseExample">
                <div class="d-grid gap-2">
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Profile</a>
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Profile</a>
                    <a href="" class="btn btn-outline-dark border-0 text-start ps-4">Profile</a>
                </div>
            </div>
            <form method="post" class="">
                <button name="logout" class="btn btn-outline-secondary border-0"><i class="fa-solid fa-arrow-right-from-bracket fa-xl" style="color: #616161;"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="col">

    </div>
</div>


<?php require_once ("../Layout/footer.php") ?>