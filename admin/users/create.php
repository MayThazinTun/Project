<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/userDb.php');

$name = $email = $password = $role = "";
$name_error = $email_error = $password_error = $role_error = "";
$photos_error = "";

// Define the folder for default avatars
$default_avatar_folder = "../../images/avatars/";

// Get the list of default avatars
$default_avatars = array_diff(scandir($default_avatar_folder), array('..', '.'));

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $role = htmlspecialchars($_POST["role"]);

    // Check if a default avatar is selected
    $selected_avatar = isset($_POST['default_avatar']) ? htmlspecialchars($_POST['default_avatar']) : null;

    // Upload Images
    $photos = $_FILES['images'];
    $photos_name = $photos['name'];
    $photos_tmp = $photos['tmp_name'];
    $photos_error_array = $photos['error'];
    $photos_paths = [];

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
            $uploadDir = "../../images/users/";
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

    if (empty($name)) $name_error = "Name must not be empty";
    if (empty($email)) $email_error = "Email must not be empty";
    if (empty($password)) $password_error = "Password must not be empty";
    if (empty($role)) $role_error = "Role must not be empty";

    if (empty($name_error) && empty($email_error) && empty($password_error) && empty($role_error) && empty($photos_error)) {
        $databaseEmail = get_user_by_email($mysqli, $email);
        if ($databaseEmail && $databaseEmail['email'] == $email) {
            $email_error = "Email already exists";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            if (!empty($photos_paths)) {
                $photo_paths_str = implode(",", $photos_paths);
            } else if (!empty($selected_avatar)) {
                $photo_paths_str = $selected_avatar;
            } else {
                $photo_paths_str = "../../images/avatars/default_avatar1.png"; // Default avatar if no image is uploaded or selected
            }
            if (create_user($mysqli, $name, $email, $password, $role, $photo_paths_str)) {
                header("Location: index.php");
                $name = $email = $password = $role = "";
                exit;
            } else {
                $invalid = "Something went wrong";
            }
        }
    }
}
?>

<div class="container mt-2">
    <h1 class="text-center my-4">Create New User</h1>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-5">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="name" class="form-label">Name</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" id="name">
                        <small class="text-danger"><?php echo htmlspecialchars($name_error); ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="col-8">
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" id="email">
                        <small class="text-danger"><?php echo htmlspecialchars($email_error); ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="col-8">
                        <input type="password" name="password" class="form-control" id="password">
                        <small class="text-danger"><?php echo htmlspecialchars($password_error); ?></small>
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
                        <label class="form-label">Default Avatars</label>
                    </div>
                    <div class="col-8 d-flex flex-wrap">
                        <?php foreach ($default_avatars as $avatar): ?>
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="default_avatar" value="<?php echo htmlspecialchars($default_avatar_folder . $avatar); ?>">
                                <label class="form-check-label">
                                    <img src="<?php echo htmlspecialchars($default_avatar_folder . $avatar); ?>" alt="Default Avatar" style="max-width: 60px; max-height: 60px;">
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="role" class="form-label">Role</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select" name="role">
                            <option selected value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <small class="text-danger"><?php echo htmlspecialchars($role_error); ?></small>
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
