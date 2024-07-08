<?php require_once ("./Login/header.php");
require_once ("./database/typeDb.php");
require_once ("./database/sizeDb.php");
require_once ("./database/colorDb.php");
require_once ("./database/stickerDb.php");
require_once ("./database/custom_add.php");

$user = null;
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
}
if ($user) {
    if ($user['role'] === 'admin') {
        header("Location:./admin/users/index.php");
    } else {
        header("Location:./user/index.php");
    }
}

$shirt_types = get_all_types($mysqli);
$shirt_sizes = get_all_sizes($mysqli);
$shirt_colors = get_all_colors($mysqli);
$shirt_stickers = get_all_stickers($mysqli);

?>

<div class="row justify-content-center">
    <div class="col-8 ps-4 pe-2">
        <div class="card p-3 my-3 shadow">

            <!-- choose shirt type -->
            <div>
                <h4>Type</h4>
                <form method="post">
                    <div class="d-flex overflow-auto gap-2">

                        <?php
                        if ($shirt_types != false) {
                            for ($i = 0; $i < count($shirt_types); $i++) {
                                $dir = "./images/All/types/" . $shirt_types[$i]['type_images'];
                                ?>
                                <div class="d-grid justify-content-center">
                                    <img src="<?php echo $dir ?>" class="border border-2 mx-3"
                                        style="width:150px; height:150px;">

                                    <button class="btn btn-outline-dark my-2" name="type"
                                        value="<?php echo $shirt_types[$i]['type_id'] ?>"><?php echo $shirt_types[$i]['type_name'] ?></button>
                                    <!-- <input type="text" name="type_id" value="" style="visibility: hidden; width: 0; height: 0;"> -->
                                </div>

                            <?php }
                        } ?>

                    </div>
                </form>
            </div>
            <hr>
            <!-- choose color -->
            <div>
                <h4>Colors</h4>
                <form method="post">
                    <div class="row justify-content-center">
                        <div class="col-7">
                            <div class="card" style="height:200px;">
                                <div class="m-2 gap-2 overflow-auto">
                                    <?php
                                    if ($shirt_colors != false) {
                                        foreach ($shirt_colors as $shirt_color) { ?>
                                            <button class="btn mt-2" value="<?php echo $shirt_color['color_id'] ?>" name="color"
                                                style="background-color:<?php echo $shirt_color['color_name'] ?>; width:50px; height:50px;"></button>
                                        <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 text-center">
                            <label for="colorPicker" class="fs-4">Choose your color</label>
                            <div class="cp_wrapper">
                                <input type="color" name="colorPicker" id="colorPicker" value="#ff8888" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <!-- choose size -->
            <div>
                <h4>Size</h4>
                <div>
                    <?php
                    if ($shirt_sizes != false) {
                        foreach ($shirt_sizes as $shirt_size) { ?>
                            <buttton class="btn btn-outline-secondary"><?php echo $shirt_size['size'] ?></buttton>
                        <?php }
                    } ?>
                </div>
            </div>
            <hr>
            <!-- choose sticker or add photo -->
            <div>
                <div class="row justify-content-center">
                    <div class="col">
                        <h4>Sticker</h4>
                        <div class="card mb-3" style="height:200px;">
                            <div class="m-2 gap-3 overflow-auto">
                                <?php
                                if ($shirt_stickers != false) {
                                    foreach ($shirt_stickers as $shirt_sticker) {
                                        $dir = "./images/All/stickers/" . $shirt_sticker['sticker_images'];
                                        ?>
                                        <button class="btn p-2 m-2" style="width:100px; height:100px;">
                                            <img src="<?php echo $dir ?>" alt="" style="width:80px; heiht:80px;"></button>
                                    <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <label for="upload_image" class="btn btn-outline-secondary form-label">Choose from your
                            browser</label>
                        <input type="file" name="images[]" id="upload_image" accept="image/*" class="form-control"
                            style="visibility: hidden; width: 0; height: 0;">
                    </div>
                </div>
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
            <div class="overflow-auto">
                <div class="card" style="height: 200px;">
                    <?php
                    if (count($type) != 0) {
                        $dir = "../images/All/types/" . $type[0]['type_images'];
                        ?>
                        <img src="<?php echo $dir ?>" alt="" style="height:200px; width:auto">
                        <?php
                    } ?>
                </div>
                <div class="d-flex">
                    <?php
                    if (count($color) != 0) {
                        ?>
                        <div class="d-flex">
                            Color:
                            <div class="border border-1 rounded"
                                style="width:70px; heigth:50px; background-color:<?php echo $color[0]['color_name'] ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div>
                    note
                </div>
                <div>
                    Price
                </div>
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
                <!-- <a class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">Order</a> -->
            </div>
        </div>
    </div>



    <?php require_once ("./Login/footer.php") ?>