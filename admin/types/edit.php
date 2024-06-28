<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/typeDb.php');

$type_price = "";
$type_price_error = "";
$type_name = $type_name_error = "";
$photos_error = "";
$current_photos = [];
$invalid = "";

if (isset($_GET['updated_id'])) {
    $type_id = $_GET['updated_id'];
    $result = get_type_by_id($mysqli, $type_id);
    $types = $result->fetch_assoc();
    $type_price = $types['type_price'];
    $type_name = $types['type_name'];
    $current_photos = explode(',', $types['type_images']);
}

if (isset($_POST['update'])) {
    $type_price = htmlspecialchars($_POST["type_price"]);
    $type_name = htmlspecialchars($_POST["type_name"]);

    // deleted photos
    if (isset($_POST['delete_photos'])) {
        foreach ($_POST['delete_photos'] as $delete_index) {
            unset($current_photos[$delete_index]);
        }
        $current_photos = array_values($current_photos); 
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
                $new_photos_paths[] = $photo_destination;
            } else {
                $photos_error = "Error uploading file: " . $photo_name;
                break;
            }
        }
    }

    if (empty($type_price)) $type_price_error = "Type Price must not be empty";
    
    if(empty($type_name)) $type_name_error = "Name must not be empty";

    if (empty($type_price_error) && empty($photos_error) && empty($type_id_error)) {
        // Update user
        $photo_paths_str = implode(",", array_merge($current_photos, $new_photos_paths));
        if (update_type_by_id($mysqli, $type_id, $type_price, $photo_paths_str, $type_name)) {
            header("Location: index.php");
            exit;
        } else {
            $invalid = "Something went wrong";
        }
    }
}
?>

<div class="container">
    <h1 class="text-center my-2">Update Types</h1>
    <?php if ($invalid): ?>
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
                        <label for="type_price" class="form-label">Type Price</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="type_price" class="form-control" value="<?php echo htmlspecialchars($type_price); ?>" id="type_price">
                        <small class="text-danger"><?php echo $type_price_error; ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="type_name" class="form-label">Type name</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="type_name" class="form-control" value="<?php echo htmlspecialchars($type_name); ?>" id="type_name">
                        <small class="text-danger"><?php echo $type_name_error; ?></small>
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
                                <?php foreach ($current_photos as $index => $photo) : ?>
                                    <div class="me-2 mb-2">
                                        <img src="<?php echo htmlspecialchars($photo); ?>" alt="User Photo" class="img-thumbnail" style="width: 100px; height: 100px;">
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
