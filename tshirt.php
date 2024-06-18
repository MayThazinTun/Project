<?php require_once ("./Login/header.php");
$user = null;
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
}
if ($user) {
    if ($user['role']==='admin') {
        header("Location:./admin/index.php");
    } else {
        header("Location:./user/index.php");
    }
}
?>

<div class="row mx-1">
    <div class="col-8 px-4">
        <!-- choose shirt type -->
        <div>
            <h4>Type</h4>
            <div>

            </div>
        </div>
        <hr>
        <!-- choose color -->
        <div>
            <h4>Colors</h4>
            <div>

            </div>
        </div>
        <hr>
        <!-- choose size -->
        <div>
            <h4>Size</h4>
            <div>

            </div>
        </div>
        <hr>
        <!-- choose sticker or add photo -->
        <div>
            <div class="row justify-content-center">
                <div class="col">
                    <h4>Sticker</h4>
                </div>
                <div class="col text-center">
                    <form id="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="file-input-wrapper">
                            <input type="file" id="file" name="file" class="file-input" accept="image/*">
                            <label for="file" class="file-label" id="file-label">Choose a file</label>
                        </div>
                        <div class="preview" id="preview">
                            <img id="preview-image" src="" alt="Image preview">
                        </div>
                        <a class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">Upload</a>
                    </form>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>
    <div class="col-4 p-3">
        <div class="card p-3">
            <div class="d-flex justify-content-between">
                <h3>Choose your type</h3>
                <button class="btn btn-outline-secondary">clear</button>
            </div>
            <hr>
            <div>
                type that you choose
            </div>
            <div>
                color, size, sticker
            </div>
            <div>
                note
            </div>
            <div>
                Price
            </div>
            <div class="row justify-content-center gap-2 px-2 py-2">
                <button type="button" class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">
                    Add to cart
                </button>

                <!-- Modal -->
                <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                You need to login first!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <a href="./Register/signin.php" class="btn btn-dark">OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">Order</a>
            </div>
        </div>
    </div>



    <?php require_once ("./Login/footer.php") ?>