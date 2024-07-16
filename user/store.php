<?php
require_once ("../database/index.php");
require_once ("../database/categoryDb.php");
require_once ("../database/productDb.php");
require_once ("../database/add_to_cart.php");


$message = false;

if (isset($_GET['product_id'])) {
    $product = get_product_by_id($mysqli, $_GET['product_id']);
    $categories = get_category_by_id($mysqli, $product['category_id']);
    $category_id = $categories['category_id'];

    $isNew = true;
    $newCategory = true;
    for ($i = 0; $i < count($cart); $i++) {

        if ($_GET['product_id'] == $cart[$i]['product_id']) {
            $isNew = false;
            if ($product['product_quantity'] > $cart[$i]['product_quantity']) {
                $cart[$i]['product_quantity']++;
                $cart[$i]['total_amount'] = $cart[$i]['product_quantity'] * $cart[$i]['product_price'];
            } else {
                $message = true;
            }
        }
    }
    // echo '<pre>';
    // var_dump($categories['category_id']);
    // var_dump($_SESSION['category']);
    for ($i = 0; $i < count($cate); $i++) {
        if ($category_id == $cate[$i]['category_id']) {
            $newCategory = false;
            $cate[$i]['category_qty']++;
            $cate[$i]['amount'] = $cate[$i]['category_qty'] * $cate[$i]['price'];
        }
    }
    // echo $isNew;
    if ($isNew) {
        (array_push($cart, [
            'product_id' => $product['product_id'],
            'category_id' => $product['category_id'],
            'product_name' => $product['product_name'],
            'product_size' => $product['product_size'],
            'product_color' => $product['product_color'],
            'product_price' => $product['product_price'],
            'product_quantity' => 1,
            'total_amount' => $product['product_price'],
            'product_images' => $product['product_images']
        ]));
    }
    if ($newCategory) {
        array_push($cate, [
            'category_id' => $categories['category_id'],
            'price' => $product['product_price'],
            'category_qty' => 1,
            'amount' => $product['product_price']
        ]);
    }

    $_SESSION['products'] = $cart;
    $_SESSION['category'] = $cate;
    if (!$message) {
        if (isset($_GET['category_id'])) {
            header("Location:../user/store.php?category_id=$_GET[category_id]");
        } else {
            header("Location:../user/store.php");
        }
    }
}
require_once ("./Layout/header.php");
?>

<div class="row">
    <div class="col-auto">
        <div class="shadow">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-white" style="width: 200px; height:100vh;">
            <div class="fs-5 ps-3">
                Catagories
            </div>
            <hr>
            <div class="btn-group-vertical gap-2">

                <button class="btn btn-outline-secondary border-0 text-start ps-4"
                    onclick="location.href='./store.php';">All</button>
                <?php
                $categories = get_all_categories($mysqli);
                while ($category = $categories->fetch_assoc()) {
                    ?>
                    <button class="btn btn-outline-secondary border-0 text-start ps-4"
                        onclick="location.href='./store.php?category_id=<?php echo $category['category_id'] ?>';">
                        <?php echo $category['category_name'] ?>
                    </button>
                    <?php
                }
                ?>
                <!-- <button class="btn btn-outline-secondary border-0 text-start ps-4">database</button> -->

            </div>
        </div>
        </div>
    </div>
    <div class="col overflow-auto" style="height:100vh;">
        <div>
            <?php if (isset($_GET['category_id'])) {
                $category = get_category_by_id($mysqli, $_GET['category_id']);
                ?>
                <h1> <?php echo $category['category_name'] ?> </h1>
            <?php } else { ?>
                <h1> All </h1>
            <?php } ?>
            <hr>
        </div>
        <div class="card-content row gap-5">
            <?php
            //Product by category
            $products = getAll($mysqli);
            if (isset($_GET['category_id'])) {
                $products = get_product_by_category_id($mysqli, $_GET['category_id']);
            }
            if ($products) {
                
                while ($product = $products->fetch_assoc()) {
                    
                    ?>
                    <div class="card col-2 ms-5 mt-3 p-1 mb-3 shadow" style="width:280px; height: auto;">
                        <?php $photos = explode(',', $product['product_images']);
                        $dir = "../images/All/products/".$photos[0];
                        if (!empty($photos[0])): ?>
                            <img src="<?php echo $dir; ?>" class="rounded"
                                style="width:270px; height:150px;">
                        <?php else: ?>
                            <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded"
                                style="width:270px; height:150px;" alt="No Image Available">
                        <?php endif; ?>
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['product_name'] ?></h5>
                            <p class="card-text">
                                Color : <?php echo $product['product_color'] ?> <br>
                                Size : <?php echo $product['product_size'] ?> <br>
                                Price : <?php echo $product['product_price'] ?>
                            </p>
                            <div class="row justify-content-center gap-2 px-2">
                                <?php if (isset($_GET['category_id'])) { ?>
                                    <a type="button" class="col btn btn-dark"
                                        href="./store.php?product_id=<?php echo $product['product_id'] ?>&category_id=<?php echo $product['category_id'] ?>">
                                        Add to cart
                                    </a>
                                <?php } else { ?>
                                    <a type="button" class="col btn btn-dark"
                                        href="./store.php?product_id=<?php echo $product['product_id'] ?>">
                                        Add to cart
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <h1 class="text-secondary text-center mt-5">Out of stock!</h1>
            <?php } ?>
        </div>

    </div>
</div>
<div class="shadow-top">
<?php require_once ("./Layout/footer.php") ?>
</div>