<?php 
require_once ("../database/add_to_cart.php");

?>

<nav class="row justify-content-between py-2 px-3 border border-bottom-2">
    <div class="col-auto d-flex align-item-center">
        <img src="../images/Logo.png" class="rounded ms-3 me-3" style="width: 50px;height: 50px;">
        <h3 class="m-0 py-2"><a href="../user/index.php" style="text-decoration:none;" class="text-dark">Tee World
                Myanmar</a></h3>
    </div>
    <div class="col-auto m-0 py-2">
        <ul class="nav">
            <li class="nav-item">
                <a href="./index.php" class="nav-link text-dark" title="Home"><i class="fa-solid fa-house fa-xl"
                        style="color: #000000;"></i></a>
            </li>
            <li class="nav-item">
                <a href="./tshirt.php" class="nav-link text-dark" title="T-shirts"><i class="fa-solid fa-shirt fa-xl"
                        style="color: #000000;"></i></a>
            </li>
            <li class="nav-item">
                <a href="./store.php" class="nav-link text-dark" title="Store"><i class="fa-solid fa-store fa-xl"
                        style="color: #000000;"></i></a>
            </li>
            <li class="nav-item" aria-label="">
                <!-- check already login or not -->

                <a href="./carts.php" class="nav-link text-dark position-relative" title="Cart">
                    <i class="fa-solid fa-cart-shopping fa-xl" style="color: #000000;"></i>
                    <?php
                    $i = 0;
                    foreach ($cart as $product) {
                        $i = $i + $product['product_quantity'];
                    }
                    ?>
                    <span class="position-absolute top-2 start-80 translate-middle badge rounded-pill bg-danger"><?php echo $i ?></span>
                </a>
            </li>

            <!-- history after login or register-->
            <li class="nav-item">
                <a href="./history.php" class="nav-link text-dark" title="History"><i
                        class="fa-solid fa-clock-rotate-left fa-xl" style="color: #000000;"></i></a>
            </li>
            <!-- change login btn into myaccount after login -->
            <!-- <li class="nav-item ms-3">
                <button type="button" class="btn btn-dark p-0">
                    <a href="../Register/signin.php" class="nav-link text-white p-2"><i
                            class="fa-regular fa-circle-user fa-lg" style="color: #ffffff;"></i> Login</a>
                </button>
            </li> -->
            <li class="nav-item">
                <a href="./account.php" class="nav-link text-dark" title="My Account"><i
                        class="fa-solid fa-circle-user fa-xl" style="color: #000000;"></i></a>
            </li>
        </ul>
    </div>
</nav>