<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/userDb.php');
require_once('../../database/itemDb.php');
require_once('../../database/categoryDb.php');
require_once('../../database/typeDb.php');
require_once('../../database/colorDb.php');
require_once('../../database/sizeDb.php');
require_once('../../database/stickerDb.php');

$category_id = $type_id = $color_id = $size_id = $sticker_id = $item_price = $item_quantity = $item_note = "";
$category_id_error = $type_id_error = $color_id_error = $size_id_error = $sticker_id_error = $item_price_error = $item_quantity_error = $invalid = $item_note_error = "";
$photos_error = "";

if (isset($_POST['submit'])) {
    $category_id = htmlspecialchars($_POST["category_id"]);
    $type_id = htmlspecialchars($_POST["type_id"]);
    $color_id = htmlspecialchars($_POST["color_id"]);
    $size_id = htmlspecialchars($_POST["size_id"]);
    $sticker_id = htmlspecialchars($_POST["sticker_id"]);
    $item_price = htmlspecialchars($_POST["item_price"]);
    $item_quantity = htmlspecialchars($_POST["item_quantity"]);
    $item_note = htmlspecialchars($_POST["item_note"]);

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
            $uploadDir = "../../images/All/items/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $photo_destination = $uploadDir . $newFileName;
            if (move_uploaded_file($photos_tmp[$index], $photo_destination)) {
                $photos_paths[] = $photo_destination;
            } else {
                $photos_error = "Error uploading file: " . $photo_name;
                break;
            }
        }
    }

    // if (empty($type_id) && empty($color_id) && empty($size_id) && empty($sticker_id)) {
    //     if (empty($category_id)) {
    //         $category_id_error = "Category is required";
    //     }
    //     if (empty($item_price)) {
    //         $item_price_error = "Price is required";
    //     }
    //     if (empty($item_quantity)) {
    //         $item_quantity_error = "Quantity is required";
    //     }
    //     if (empty($item_note)) {
    //         $item_note_error = "Description is required";
    //     }

    //     if (empty($item_price_error) && empty($item_quantity_error)) {
    //         $photo_paths_str = implode(",", $photos_paths);
    //         $result = create_product($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $item_price, $item_quantity, $item_note);
    //         if ($result) {
    //             header("Location: index.php");
    //             exit;
    //         } else {
    //             $invalid = "Something went wrong";
    //         }
    //     }
    // }else{
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
        if (empty($item_price)) {
            $item_price_error = "Price is required";
        }
        if (empty($item_quantity)) {
            $item_quantity_error = "Quantity is required";
        }
        if (empty($item_price_error) && empty($item_quantity_error)) {
            $photo_paths_str = implode(",", $photos_paths);
            // $result = createProductAll($mysqli, $category_id, $type_id, $color_id, $size_id, $sticker_id, $item_price, $item_quantity, $item_note);
            if ($result) {
                header("Location: index.php");
                exit;
            } else {
                $invalid = "Something went wrong";
            }
        }
    //}
}

?>

<div class="container mt-2">
    <h1 class="text-center my-4">Create New Product</h1>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-4">
            <?php if ($invalid)
                echo    "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>$invalid</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>"
            ?>
            <form class="row" method="post" enctype="multipart/form-data" >
                <!-- <div class="col-md-6 mb-2">
                    <label for="category_id" class="form-label">Product Category</label>
                    <div>
                        <select class="form-select" name="category_id">
                            <?php //$categories = get_all_categories($mysqli);
                            //foreach ($categories as $category) {
                                //echo '<option value="' . $category['category_id'] . '">' . $category['category_name'] . '</option>';
                            //}
                            ?>
                        </select>
                        <small class="text-danger"><?php //echo $category_id_error ?></small>
                    </div>
                </div> -->
                <div class="col-md-6 mb-2">
                    <label for="type_id" class="form-label">Type</label>
                    <div>
                        <select class="form-select" name="type_id">
                            <option value="" selected>Select type(optional)...</option>
                            <?php $types = get_all_types($mysqli);
                            foreach ($types as $type) {
                                echo '<option value="' . $type['type_id'] . '">' . $type['type_price'] . '</option>';
                            }
                            ?>
                        </select>
                        <small class="text-danger"><?php echo $type_id_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="color_id" class="form-label">Color</label>
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
                    <label for="size_id" class="form-label">Size</label>
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
                    <label for="sticker_id" class="form-label">Sticker</label>
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
                <!-- <div class="col-md-6 mb-2">
                    <label for="product_name" class="form-label">Enter Your Product Name</label>
                    <div>
                        <input type="text" name="product_name" class="form-control" value="<?php //echo $product_name ?>" id="product_name">
                        <small class="text-danger"><?php //echo $product_name_error ?></small>
                    </div>
                </div> -->
                <div class="col-md-6 mb-2">
                    <label for="item_price" class="form-label">Item Price</label>
                    <div>
                        <input type="number" name="item_price" class="form-control" value="<?php echo $item_price ?>" id="item_price">
                        <small class="text-danger"><?php echo $item_price_error ?></small>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="item_quantity" class="form-label">Item Quantity</label>
                    <div>
                        <input type="number" name="item_quantity" class="form-control" value="<?php echo $item_quantity ?>" id="item_quantity">
                        <small class="text-danger"><?php echo $item_quantity_error ?></small>
                    </div>
                </div>
                <!-- <div class="col-md-6 mb-2">
                    <label for="product_images" class="form-label">Product Images</label>
                    <div>
                        <input type="file" name="images[]" class="form-control" id="images" multiple>
                        <small class="text-danger"><?php //echo htmlspecialchars($photos_error); ?></small>
                    </div>
                </div> -->
                <div class="col-md-6 mb-2">
                    <label for="item_note" class="form-label">Item note</label>
                    <div>
                        <input type="text" name="item_note" class="form-control" value="<?php echo $item_note ?>" id="item_note">
                        <small class="text-danger"><?php echo $item_note_error ?></small>
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