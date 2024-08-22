<?php

require_once("./Login/header.php");

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

?>

<div class="container-fluid py-1" id="contact">
    <div class="row p-3 mx-1 justify-content-center">
        <div class="col-6 d-flex align-item-center">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                type="module"></script>

            <dotlottie-player src="https://lottie.host/f0401a84-6ddb-40cb-8f1e-c33ea13b0c57/s4F8IVX2cJ.json"
                background="transparent" speed="1" style="width: 450px; height: 450px;" loop
                autoplay></dotlottie-player>
        </div>
        <div class="col-5 border border-1 border-light text-center py-5" id="card"
            style="border-radius: 20px; background: rgb(255,255,255);
                    background: linear-gradient(90deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 35%, rgba(255,255,255,0.19931722689075626) 100%);">
            <h2 class="fst-italic fs-1" style="color:lightblue; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Welcome from our website!</h2>
            <div class="btn border border-1-dark mt-5" id="btn"><a href="./store.php"
                    style="text-decoration:none; color:black;"> Shop now <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>