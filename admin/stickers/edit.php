<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/stickerDb.php');

$sticker_price = "";
$sticker_price_error = "";
$photos_error = "";
$current_photos = [];
$invalid = "";

if (isset($_GET['updated_id'])) {
    $sticker_id = $_GET['updated_id'];
    $result = get_sticker_by_id($mysqli, $sticker_id);
    $sticker = $result->fetch_assoc();
    $sticker_price = $sticker['sticker_price'];
    $current_photos = explode(',', $sticker['sticker_images']);
}

if (isset($_POST['update'])) {
    $sticker_price = htmlspecialchars($_POST["sticker_price"]);

    // Handle deleted photos
    if (isset($_POST['delete_photos'])) {
        foreach ($_POST['delete_photos'] as $delete_index) {
            if (isset($current_photos[$delete_index])) {
                // Delete the physical file if it exists
                if (file_exists($current_photos[$delete_index])) {
                    unlink($current_photos[$delete_index]);
                }
                // Remove the photo from the array
                unset($current_photos[$delete_index]);
            }
        }
        $current_photos = array_values($current_photos); // Re-index the array
    }

    // Upload new images
    $photos = $_FILES['images'];
    $photos_name = $photos['name'];
    $photos_tmp = $photos['tmp_name'];
    $photos_error_array = $photos['error'];
    $new_photos_paths = [];

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
            $uploadDir = "../../images/All/stickers/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $photo_destination = $uploadDir . $newFileName;
            if (move_uploaded_file($photos_tmp[$index], $photo_destination)) {
                $new_photos_paths[] = $newFileName;
            } else {
                $photos_error = "Error uploading file: " . $photo_name;
                break;
            }
        }
    }

    if (empty($sticker_price)) $sticker_price_error = "Sticker Price must not be empty";

    if (empty($sticker_price_error) && empty($photos_error)) {
        // Update sticker with new photo paths
        $photo_paths_str = implode(",", array_merge($current_photos, $new_photos_paths));
        if (update_sticker_by_id($mysqli, $sticker_id, $sticker_price, $photo_paths_str)) {
            header("Location: index.php");
            exit;
        } else {
            $invalid = "Something went wrong";
        }
    }
}
?>

<div class="container">
    <h1 class="text-center my-2">Update Sticker</h1>
    <?php if ($invalid) : ?>
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong><?php echo $invalid; ?></strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-5">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="sticker_price" class="form-label">Sticker Price</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="sticker_price" class="form-control" value="<?php echo htmlspecialchars($sticker_price); ?>" id="sticker_price">
                        <small class="text-danger"><?php echo $sticker_price_error; ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="images" class="form-label">Images</label>
                    </div>
                    <div class="col-8">
                        <input type="file" name="images[]" class="form-control" id="images" multiple>
                        <small class="text-danger"><?php echo htmlspecialchars($photos_error); ?></small>
                        <div class="mt-2">
                            <label>Current Photos</label>
                            <div class="d-flex flex-wrap">
                                <?php foreach ($current_photos as $index => $photo) : 
                                 $dir ="../../images/All/stickers/".$photo;
                                 ?>
                                    <div class="me-2 mb-2">
                                        <img src="<?php echo htmlspecialchars($dir); ?>" alt="Sticker Photo" style="width: 100px; height: 100px;" class="img-thumbnail">
                                        <div>
                                            <input type="checkbox" name="delete_photos[]" value="<?php echo $index; ?>"> Delete
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="./index.php" class="btn btn-warning">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('../layouts/adminFooter.php'); ?>