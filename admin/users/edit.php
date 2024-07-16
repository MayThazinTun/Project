<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/userDb.php');

$name = $email = $password = $role = $address ="";
$name_error = $email_error = $password_error = $role_error = $invalid = $address_error = "";
$photos_error = "";
$current_photos = [];


if (isset($_GET['updated_id'])) {
    $edit_id = $_GET['updated_id'];
    $result = get_user_by_id($mysqli, $edit_id);
    $user = $result->fetch_assoc();
    $name = $user['name'];
    $email = $user['email'];
    $address = $user['address'];
    $password = $user['password'];
    $role = $user['role'];
    $current_photos = explode(',', $user['images']);
    // die(var_dump($current_photos));
}


if (isset($_POST['update'])) {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $address = htmlspecialchars($_POST["address"]);
    $password = htmlspecialchars($_POST["password"]);
    $role = htmlspecialchars($_POST["role"]);


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
            $uploadDir = "../../images/All/users/";
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

    if (empty($name)) $name_error = "Name must not be empty";
    if (empty($email)) $email_error = "Email must not be empty";
    if (empty($address)) $address_error = "Address must not be empty";
    if (empty($password)) $password_error = "Password must not be empty";
    if (empty($role)) $role_error = "Role must not be empty";

    if (empty($name_error) && empty($email_error) && empty($password_error) && empty($role_error) && empty($photos_error)) {
        // Update user
        $photo_paths_str = implode(",", array_merge($current_photos, $new_photos_paths));
        if (update_user_by_id($mysqli, $edit_id, $name, $email, $address, $password, $role, $photo_paths_str)) {
            header("Location: index.php");
            $name = $email = $password = $role = "";
            exit;
        } else {
            $invalid = "Something went wrong";
        }
    }
}

?>

<div class="container">
    <h1 class="text-center my-2">Update User</h1>
    <?php if ($invalid)
        echo    "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>$invalid</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>"
    ?>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-5">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="name" class="form-label">Name</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="name" class="form-control" value="<?php echo $name ?>" id="name">
                        <small class="text-danger"><?php echo $name_error ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="col-8">
                        <input type="email" name="email" class="form-control" value="<?php echo $email ?>" id="email">
                        <small class="text-danger"><?php echo $email_error ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="address" class="form-label">Address</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="address" class="form-control" value="<?php echo $address ?>" id="address">
                        <small class="text-danger"><?php echo $address_error ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="col-8">
                        <input type="password" name="password" class="form-control" value="<?php echo $password ?>" id="password">
                        <small class="text-danger"><?php echo $password_error ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="role" class="form-label">Role</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select" name="role">
                            <option <?php if ($role === 'user') echo 'selected'; ?> value="user">User</option>
                            <option <?php if ($role === 'admin') echo 'selected'; ?> value="admin">Admin</option>
                        </select>
                        <small class="text-danger"><?php echo $role_error ?></small>
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
                                <?php foreach ($current_photos as $photo) :
                                    $dir = "../../images/All/users/".$photo;
                                    ?>
                                    <div class="me-2 mb-2">
                                        <img src="<?php echo htmlspecialchars($dir); ?>" alt="User Photo" style="max-width: 50px; max-height: 50px;">
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

</div>

<?php require_once('../layouts/adminFooter.php'); ?>