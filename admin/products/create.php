<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/userDb.php');
require_once('../../database/productDb.php');
require_once('../../database/categoryDb.php');
require_once('../../database/typeDb.php');
require_once('../../database/colorDb.php');
require_once('../../database/sizeDb.php');
require_once('../../database/stickerDb.php');


$category_id = $type_id = $color_id = $size_id = $sticker_id = $product_name = $product_price = $product_quantity = "";
$category_id_error = $type_id_error = $color_id_error = $size_id_error = $sticker_id_error = $product_name_error = $product_price_error = $product_quantity_error = $invalid = "";

if (isset($_POST['submit'])) {
    $category_id = htmlspecialchars($_POST["category_id"]);
    $type_id = htmlspecialchars($_POST["type_id"]);
    $color_id = htmlspecialchars($_POST["color_id"]);
    $size_id = htmlspecialchars($_POST["size_id"]);
    $sticker_id = htmlspecialchars($_POST["sticker_id"]);
    $product_name = htmlspecialchars($_POST["product_name"]);
    $product_price = htmlspecialchars($_POST["product_price"]);
    $product_quantity = htmlspecialchars($_POST["product_quantity"]);

    if (empty($type_id) && empty($color_id) && empty($size_id) && empty($sticker_id)) {
        if (empty($category_id)) {
            $category_id_error = "Category is required";
        }
        if (empty($product_name)) {
            $product_name_error = "Name is required";
        }
        if (empty($product_price)) {
            $product_price_error = "Price is required";
        }
        if (empty($product_quantity)) {
            $product_quantity_error = "Quantity is required";
        }

        if (empty($product_name_error) && empty($product_price_error) && empty($product_quantity_error)) {
            $result = create_product($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $product_name, $product_price, $product_quantity);
            if ($result) {
                header("Location: index.php");
                exit;
            } else {
                $invalid = "Something went wrong";
            }
        }
    }else{
        if (empty($category_id)) {
            $category_id_error = "Category is required";
        }
        if(empty($type_id)) {
            $type_id_error = "Type is required";
        }
        if(empty($color_id)) {
            $color_id_error = "Color is required";
        }
        if(empty($size_id)) {
            $size_id_error = "Size is required";
        }
        if (empty($product_name)) {
            $product_name_error = "Name is required";
        }
        if (empty($product_price)) {
            $product_price_error = "Price is required";
        }
        if (empty($product_quantity)) {
            $product_quantity_error = "Quantity is required";
        }
        if (empty($product_name_error) && empty($product_price_error) && empty($product_quantity_error)) {
            $result = createProductAll($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $product_name, $product_price, $product_quantity);
            if ($result) {
                header("Location: index.php");
                exit;
            } else {
                $invalid = "Something went wrong";
            }
        }
    }
}

?>

<div class="container mt-2">
    <h1 class="text-center my-4">Create New Product</h1>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-5">
            <?php if ($invalid)
                echo    "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>$invalid</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>"
            ?>
            <form class="row" method="post">
                <div class="col-md-6 mb-2">
                    <label for="category_id" class="form-label">Product Category</label>
                    <div>
                        <select class="form-select" name="category_id">
                            <?php $categories = get_all_categories($mysqli);
                            foreach ($categories as $category) {
                                echo '<option value="' . $category['category_id'] . '">' . $category['category_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <small class="text-danger"><?php echo $category_id_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="type_id" class="form-label">Product Type</label>
                    <div>
                        <select class="form-select" name="type_id">
                            <option value="" selected>Select type(optional)...</option>
                            <?php $types = get_all_types($mysqli);
                            foreach ($types as $type) {
                                echo '<option value="' . $type['type_id'] . '">' . $type['type_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <small class="text-danger"><?php echo $type_id_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="color_id" class="form-label">Product Color</label>
                    <div>
                        <select class="form-select" name="color_id">
                            <option value="" selected>Select color(optional)...</option>
                            <?php $colors = get_all_colors($mysqli);
                            foreach ($colors as $color) {
                                echo '<option value="' . $color['color_id'] . '">' . $color['color_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <small class="text-danger"><?php echo $color_id_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="size_id" class="form-label">Product Size</label>
                    <div>
                        <select class="form-select" name="size_id">
                            <option value="" selected>Select size(optional)...</option>
                            <?php $sizes = get_all_sizes($mysqli);
                            foreach ($sizes as $size) {
                                echo '<option value="' . $size['size_id'] . '">' . $size['size'] . '</option>';
                            }
                            ?>
                        </select>
                        <small class="text-danger"><?php echo $size_id_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="sticker_id" class="form-label">Product Sticker</label>
                    <div>
                        <select class="form-select" name="sticker_id">
                            <option value="" selected>Select sticker(optional)...</option>
                            <?php $stickers = get_all_stickers($mysqli);
                            foreach ($stickers as $sticker) {
                                echo '<option value="' . $sticker['sticker_id'] . '">' . $sticker['sticker_price'] . '</option>';
                            }
                            ?>
                        </select>
                        <small class="text-danger"><?php echo $sticker_id_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_name" class="form-label">Enter Your Product Name</label>
                    <div>
                        <input type="text" name="product_name" class="form-control" value="<?php echo $product_name ?>" id="product_name">
                        <small class="text-danger"><?php echo $product_name_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_price" class="form-label">Product Price</label>
                    <div>
                        <input type="number" name="product_price" class="form-control" value="<?php echo $product_price ?>" id="product_price">
                        <small class="text-danger"><?php echo $product_price_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_quantity" class="form-label">Product Quantity</label>
                    <div>
                        <input type="number" name="product_quantity" class="form-control" value="<?php echo $product_quantity ?>" id="product_quantity">
                        <small class="text-danger"><?php echo $product_quantity_error ?></small>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" name="submit" class="btn btn-primary">Create</button>
                    <a href="./index.php" class="btn btn-warning">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once('../layouts/adminFooter.php'); ?>