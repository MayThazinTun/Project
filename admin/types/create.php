<?php
require_once('../layouts/adminHeader.php');
require_once('../../baseUrl.php');
require_once('../../database/typeDb.php');

$type_price = "";
$price_error = "";
$photos_error = "";
$type_name = $type_name_error = "";

// Define the folder for default avatars
$default_avatar_folder = "../../images/types/";

// Get the list of default avatars
$default_avatars = array_diff(scandir($default_avatar_folder), array('..', '.'));

if (isset($_POST['submit'])) {
    $type_price = htmlspecialchars($_POST["type_price"]);
    $type_name = htmlspecialchars($_POST["type_name"]);

    // Check if a default avatar is selected
    $selected_avatar = isset($_POST['default_avatar']) ? htmlspecialchars($_POST['default_avatar']) : null;

    // Upload Images
    $photos = $_FILES['images'];
    $photos_name = $photos['name'];
    $photos_tmp = $photos['tmp_name'];
    $photos_error_array = $photos['error'];
    $photos_paths = [];
    // die(var_dump($_FILES,$_POST));

    // Allow extensions
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
            $uploadDir = "../../images/All/types/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $photo_destination = $uploadDir . $newFileName;
            echo $photo_destination;
            if (move_uploaded_file($photos_tmp[$index], $photo_destination)) {
                $photos_paths[] = $newFileName;
            } else {
                $photos_error = "Error uploading file: " . $photo_name;
                break;
            }
        }
    }

    if (empty($type_price)) $price_error = "Price must not be empty";
    if(empty($type_name)) $type_name_error = "Name must not be empty";

    if (empty($price_error) && empty($type_name_error)) {
        if (!empty($photos_paths)) {
            $photo_paths_str = implode(",", $photos_paths);
        } else if (!empty($selected_avatar)) {
            $photo_paths_str = $selected_avatar;
        } else {
            $photo_paths_str = "type1.png";
        }
        if (create_type($mysqli, $type_price, $photo_paths_str , $type_name)) {
            header("Location: index.php");
            $type_price = $type_name= "";

            exit;
        } else {
            $invalid = "Something went wrong";
        }
    }
}

?>

<div class="container mt-2">
    <h1 class="text-center my-4">Create New Types</h1>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-5">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="type_price" class="form-label">Price</label>
                    </div>
                    <div class="col-8">
                        <input type="number" name="type_price" class="form-control" value="<?php echo htmlspecialchars($type_price); ?>" id="type_price">
                        <small class="text-danger"><?php echo htmlspecialchars($price_error); ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="type_name" class="form-label">Name</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="type_name" class="form-control" value="<?php echo htmlspecialchars($type_name); ?>" id="type_name">
                        <small class="text-danger"><?php echo htmlspecialchars($type_name_error); ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="images" class="form-label">Images</label>
                    </div>
                    <div class="col-8">
                        <input type="file" name="images[]" class="form-control" id="images" multiple>
                        <small class="text-danger"><?php echo htmlspecialchars($photos_error); ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label class="form-label">Default Types</label>
                    </div>
                    <div class="col-8 d-flex flex-wrap">
                        <?php foreach ($default_avatars as $avatar) : ?>
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="default_avatar" value="<?php echo htmlspecialchars($avatar); ?>">
                                <label class="form-check-label">
                                    <img src="<?php echo $default_avatar_folder . htmlspecialchars($avatar); ?>" alt="Default Avatar" style="max-width: 60px; max-height: 60px;">
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <button type="submit" name="submit" class="btn btn-primary">Create</button>
                    <a href="./index.php" class="btn btn-warning">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('../layouts/adminFooter.php'); ?>