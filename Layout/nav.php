<nav class="d-flex justify-content-between py-2 px-5 border border-bottom-2">
    <div class="d-flex align-item-center">
        <img src="../images/Logo.png" class="rounded me-3" style="width: 50px;height: 50px;">
        <h3 class="m-0 py-2"><a href="../user/index.php" style="text-decoration:none;" class="text-dark">Tee World
                Myanmar</a></h3>
    </div>
    <div class=" m-0 py-2">
        <ul class="nav">
            <li class="nav-item">
                <a href="../user/index.php" class="nav-link text-dark">Home</a>
            </li>
            <li class="nav-item">
                <a href="../user/tshirt.php" class="nav-link text-dark">T-shirts</a>
            </li>
            <li class="nav-item">
                <a href="../user/store.php" class="nav-link text-dark">Store</a>
            </li>
            <li class="nav-item" aria-label="">
                <!-- check already login or not -->

                <a href="../Register/signin.php" class="nav-link"><i class="fa-solid fa-cart-shopping fa-xl"
                        style="color: #000000;"></i></a>
            </li>

            <!-- history after login or register-->
            <li class="nav-item">
                <a href="../user/history.php" class="nav-link text-dark">History</a>
            </li>
            <!-- change login btn into myaccount after login -->
            <li class="nav-item ms-3">
                <button type="button" class="btn btn-dark p-0">
                    <a href="../Register/signin.php" class="nav-link text-white p-2"><i
                            class="fa-regular fa-circle-user fa-lg" style="color: #ffffff;"></i> Login</a>
                </button>
            </li>

        </ul>
    </div>
</nav>