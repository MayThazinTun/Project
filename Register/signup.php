<?php require_once ("../Login/header.php") ?>
<?php require_once ("../Login/nav.php") ?>

<div class="container-fluid py-5 "
    style="background: rgb(205,198,214); background: linear-gradient(90deg, rgba(205,198,214,1) 0%, rgba(204,126,219,1) 15%, rgba(235,169,75,1) 31%, rgba(163,233,27,1) 46%, rgba(90,227,92,1) 57%, rgba(73,240,132,1) 70%, rgba(48,209,183,1) 84%, rgba(110,167,201,1) 96%);">
    <div class="card my-5 mx-3 border-primary rounded-5 px-3 py-1"
        style="background: rgb(238,174,202); background: radial-gradient(circle, rgba(238,174,202,0.4962359943977591) 0%, rgba(148,187,233,0.5) 100%);">
        <div class="row text-center">
            <div class="col-6 align-self-center">
                <img src="../images/Logo1.png" class="border rounded-circle border-2 border-white"
                    style="width: 300px;height: 300px;">
            </div>

            <div class="col-6 align-self-center bg-white border rounded-end rounded-5 p-0">
                <div class="mx-3 my-3">
                    <h2 class="fst-italic text-success">Create an Account</h2>
                    <div class="" style="padding-left:40%;">
                        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                            type="module"></script>

                        <dotlottie-player src="https://lottie.host/470b48f3-3ef7-4f60-974b-e860436c5abd/zz4iOzJzia.json"
                            background="transparent" speed="1" style="width: 100px; height: 100px;" loop
                            autoplay></dotlottie-player>
                    </div>
                    <h5 class="fst-italic  text-success">Sing up to Continute</h5>
                </div>
                <form>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-4 text-start fs-5">
                            <label for="username" class="form-label">Username</label>
                        </div>

                        <div class="col-6">
                            <input type="text" class="form-control" id="username">
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-4 text-start fs-5">
                            <label for="email" class="form-label">Email</label>
                        </div>

                        <div class="col-6">
                            <input type="email" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-4 text-start fs-5">
                            <label for="address" class="form-label">Address</label>
                        </div>

                        <div class="col-6">
                            <input type="text" class="form-control" id="address">
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-4 text-start fs-5">
                            <label for="passowrd" class="form-label">Password</label>
                        </div>

                        <div class="col-6">
                            <input type="password" class="form-control" id="password">
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-4 text-start fs-5">
                            <label for="c_password" class="form-label">Re-password</label>
                        </div>

                        <div class="col-6 text-start">
                            <input type="password" class="form-control" id="c_password">
                            <small class="text-secondary">Confirm password</small>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
                <div class="form-check p-0 badge text-wrap text-dark mt-3">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        I have agreed to the terms and conditions.
                    </label>
                </div>
                <p>
                    Already have an account?<a href="./signin.php">Sing in</a>
                </p>
            </div>

        </div>

    </div>

</div>

<?php require_once ("../Login/footer.php") ?>