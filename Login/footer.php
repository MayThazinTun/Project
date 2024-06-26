<div class="d-grid gap-4 mx-1">
    <div class="row gap-2 bg-light">
        <div class="col text-center mb-2">
            <img src="./images/shopbag_logo.png" class="rounded me-3" style="width: 80px;height: 80px;">
        </div>
        <div class="col-3 text-center">
            <div class="input-group py-4">
                <input type="email" class="form-control" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary bg-dark" type="button" id="button-addon2"><i class="fa-solid fa-arrow-right fa-flip-vertical fa-xl" style="color: #ffffff;"></i></button>
            </div>
        </div>
        <div class="col mt-2 d-flex gap-3 justify-content-center py-4">
            <a href=""><i class="fa-brands fa-facebook fa-2xl" style="color: #000000;"></i></a>
            <a href=""><i class="fa-brands fa-twitter fa-2xl" style="color: #000000;"></i></a>
            <a href=""><i class="fa-brands fa-instagram fa-2xl" style="color: #000000;"></i></a>
            <a href=""><i class="fa-brands fa-google fa-2xl" style="color: #000000;"></i></a>
            <a href=""><i class="fa-brands fa-linkedin fa-2xl" style="color: #000000;"></i></a>
        </div>
    </div>
    <div>
        <div class="row" style="justify-content: space-evenly;">
            <div class="col-2">
                <h5 style="color:gray;">Contact Us</h5>
                <p style="color:gray;">
                    Yangon.<br>
                    +959 - 123456789
                </p>
            </div>
            <div class="col-2">
                <h5 style="color:gray;">My account</h5>
                <p>
                    <a href="" style="text-decoration: none; color:gray;">Profile</a><br>
                    <a href="" style="text-decoration: none; color:gray;">Edit Profile</a><br>
                    <a href="" style="text-decoration: none; color:gray;">Change password</a><br>
                </p>
            </div>
            <div class="col-2">
                <h5 style="color:gray;">Information</h5>
                <p>
                    <a href="" style="text-decoration: none; color:gray;">Contact Us</a><br>
                    <a href="" style="text-decoration: none; color:gray;">About Us</a><br>
                    <a href="" style="text-decoration: none; color:gray;">Shop Address</a><br>
                </p>
            </div>
            <div class="col-2">
                <h5 style="color:gray;">Catagories</h5>
                <p>
                    <?php
                    $categories = get_all_categories($mysqli);
                    while ($category = $categories->fetch_assoc()) {
                    ?>
                        <a href="./store.php?category_id=<?php echo $category['category_id'] ?>" style="text-decoration: none; color:gray;"><?php echo $category['category_name'] ?></a><br>
                    <?php
                    }
                    ?>
                </p>
            </div>
        </div>
        <div>
            <ul class="nav me-4" style="justify-content: center;">
                <li class="nav-item">
                    <a href="/" class="nav-link text-secondary">Home</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link text-secondary">T-shirts</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link text-secondary">Store</a>
                </li>
                <li class="nav-item">
                    <a href="../Register/signin.php" class="nav-link text-secondary">Cart</a>
                </li>
                <li class="nav-item">
                    <a href="../Register/signin.php" class="nav-link text-secondary">Login</a>
                </li>
            </ul>
        </div>
    </div>
    <div class=" bg-light py-3" style="height:60px;">
        <p class="text-secondary text-center">Developed by team </p>
    </div>
</div>
</body>

</html>