<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/sizeDb.php');

$size = $size_price = "";
$size_error = $size_price_error = "";


if (isset($_POST['submit'])) {
    $size = htmlspecialchars($_POST["size"]);
    $size_price = htmlspecialchars($_POST["size_price"]);

    if (empty($size)) $size_error = "size must not be empty";
    if (empty($size_price)) $size_price_error = "Size price must not be empty";

    if (empty($size_error) && empty($size_price_error)){
        create_size($mysqli, $size, $size_price);
        header("Location:./index.php");
        exit(); 
    }
}
?>

<div class="container mt-2">
    <h1 class="text-center my-4">Create New Size</h1>
    <div class="d-flex justify-content-center">
        <div class="card col-7 p-5">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="size" class="form-label">Enter Your Size</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="size" class="form-control" value="<?php echo htmlspecialchars($size); ?>" id="size">
                        <small class="text-danger"><?php echo htmlspecialchars($size_error); ?></small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-4">
                        <label for="size_price" class="form-label">Size Price</label>
                    </div>
                    <div class="col-8">
                        <input type="number" name="size_price" class="form-control" value="<?php echo htmlspecialchars($size_price); ?>" id="size_price">
                        <small class="text-danger"><?php echo htmlspecialchars($size_price_error); ?></small>
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
