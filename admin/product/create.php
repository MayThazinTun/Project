<?php
require_once ('../layouts/adminHeader.php');
require_once ('../../database/userDb.php');
require_once ('../../database/productDb.php');
require_once ('../../database/categoryDb.php');
require_once ('../../database/typeDb.php');
require_once ('../../database/colorDb.php');
require_once ('../../database/sizeDb.php');
require_once ('../../database/stickerDb.php');

$category_id = $product_name = $product_size = $product_color = $product_price = $product_quantity = $product_description = "";
$category_id_error = $product_name_error = $product_color_error = $product_price_error = $product_quantity_error = $invalid = $product_description_error = "";
$photos_error = "";

if (isset($_POST['submit'])) {
    $category_id = htmlspecialchars($_POST["category_id"]);
    $product_name = htmlspecialchars($_POST["product_name"]);
    $product_size = htmlspecialchars($_POST["product_size"]);
    $product_color = htmlspecialchars($_POST["product_color"]);
    $product_price = htmlspecialchars($_POST["product_price"]);
    $product_quantity = htmlspecialchars($_POST["product_quantity"]);
    $product_description = htmlspecialchars($_POST["product_description"]);

    // Upload Images
    $photos = $_FILES['images'];
    $photos_name = $photos['name'];
    $photos_tmp = $photos['tmp_name'];
    $photos_error_array = $photos['error'];
    $photos_paths = [];


    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    foreach ($photos_name as $index => $photo_name) {
        if (!empty($photo_name)) {
            $photo_ext = pathinfo($photo_name, PATHINFO_EXTENSION);

            if ($photos_error_array[$index] !== UPLOAD_ERR_OK) {
                $photos_error = "Error uploading file: " . $photo_name;
                break;
            }
            if (!in_array(strtolower($photo_ext), $allowed_extensions)) {
                $photos_error = "Invalid file type: " . $photo_name;
                break;
            }

            $newFileName = time() . "_" . $photo_name;
            $uploadDir = "../../images/All/products/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $photo_destination = $uploadDir . $newFileName;
            if (move_uploaded_file($photos_tmp[$index], $photo_destination)) {
                $photos_paths[] = $newFileName;
            } else {
                $photos_error = "Error uploading file: " . $photo_name;
                break;
            }
        }
    }

    if (empty($category_id)) {
        $category_id_error = "Category is required";
    }
    if (empty($product_name)) {
        $product_name_error = "Name is required";
    }
    if (empty($product_color)) {
        $product_color_error = "Color is required";
    }
    if (empty($product_price)) {
        $product_price_error = "Price is required";
    }
    if (empty($product_quantity)) {
        $product_quantity_error = "Quantity is required";
    }
    if (empty($product_description)) {
        $product_description_error = "Description is required";
    }

    if (empty($product_name_error) && empty($product_color_error) && empty($product_price_error) && empty($product_quantity_error)) {
        $photo_paths_str = implode(",", $photos_paths);
        if (empty($product_size)) {
            $result = create_product($mysqli, $category_id, $product_name, null, $product_color, $product_quantity, $product_price, $photo_paths_str, $product_description);
        } else {
            $result = create_product($mysqli, $category_id, $product_name, $product_size, $product_color, $product_quantity, $product_price, $photo_paths_str, $product_description);
        }
        if ($result) {
            header("Location: index.php");
            exit;
        } else {
            $invalid = "Something went wrong";
        }
    }
}

?>

<div class="container mt-2">
    <h1 class="text-center my-4">Create New Product</h1>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-4">
            <?php if ($invalid)
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>$invalid</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>"
                    ?>
                <form class="row" method="post" enctype="multipart/form-data">
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
                    <label for="product_name" class="form-label">Enter Your Product Name</label>
                    <div>
                        <input type="text" name="product_name" class="form-control" value="<?php echo $product_name ?>"
                            id="product_name">
                        <small class="text-danger"><?php echo $product_name_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_size" class="form-label">Enter Your Product Size</label>
                    <div>
                        <input type="text" name="product_size" class="form-control" value="<?php echo $product_size ?>"
                            id="product_size">
                        <!-- <small class="text-danger"><?php //echo $product_size_error ?></small> -->
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_color" class="form-label">Enter Your Product Color</label>
                    <div>
                        <input type="text" name="product_color" class="form-control"
                            value="<?php echo $product_color ?>" id="product_color">
                        <small class="text-danger"><?php echo $product_color_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_price" class="form-label">Product Price</label>
                    <div>
                        <input type="number" name="product_price" class="form-control"
                            value="<?php echo $product_price ?>" id="product_price">
                        <small class="text-danger"><?php echo $product_price_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_quantity" class="form-label">Product Quantity</label>
                    <div>
                        <input type="number" name="product_quantity" class="form-control"
                            value="<?php echo $product_quantity ?>" id="product_quantity">
                        <small class="text-danger"><?php echo $product_quantity_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_images" class="form-label">Product Images</label>
                    <div>
                        <input type="file" name="images[]" class="form-control" id="images" multiple>
                        <small class="text-danger"><?php echo htmlspecialchars($photos_error); ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="product_description" class="form-label">Product Description</label>
                    <div>
                        <input type="text" name="product_description" class="form-control"
                            value="<?php echo $product_description ?>" id="product_description">
                        <small class="text-danger"><?php echo $product_description_error ?></small>
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


<?php require_once ('../layouts/adminFooter.php'); ?>