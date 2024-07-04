<?php
require_once ("./Layout/header.php");
require_once ("../database/typeDb.php");
require_once ("../database/sizeDb.php");
require_once ("../database/colorDb.php");
require_once ("../database/stickerDb.php");

$shirt_types = get_all_types($mysqli);
$shirt_sizes = get_all_sizes($mysqli);
$shirt_colors = get_all_colors($mysqli);
$shirt_stickers = get_all_stickers($mysqli);

?>

<div class="row justify-content-center">
    <div class="col-8 px-4">
        <!-- choose shirt type -->
        <div>
            <h4>Type</h4>
            <div class="d-flex overflow-auto gap-2">
                <?php foreach ($shirt_types as $shirt_type) {
                    $dir = "../images/All/types/" . $shirt_type['type_images'];
                    ?>
                    <div class="d-grid justify-content-center">
                        <img src="<?php echo $dir ?>" class="border border-2 mx-3" style="width:150px; height:150px;">

                        <a class="btn btn-outline-dark my-2"><?php echo $shirt_type['type_name'] ?></a>
                    </div>

                <?php } ?>
            </div>
        </div>
        <hr>
        <!-- choose color -->
        <div>
            <h4>Colors</h4>
            <div class="row justify-content-center">
                <div class="col-7">
                    <div class="card" style="height:200px;">
                        <div class="m-2 gap-2 overflow-auto">
                        <?php foreach($shirt_colors as $shirt_color) { ?>
                            <button class="btn mt-2" style="background-color:<?php echo $shirt_color['color_name'] ?>; width:50px; height:50px;"></button>
                            <?php } ?>
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
        </div>
        <hr>
        <!-- choose size -->
        <div>
            <h4>Size</h4>
            <div>
                <?php foreach($shirt_sizes as $shirt_size) { ?>
                    <a href="" class="btn btn-outline-secondary"><?php echo $shirt_size['size'] ?></a>
                    <?php } ?>
            </div>
        </div>
        <hr>
        <!-- choose sticker or add photo -->
        <div>
            <div class="row justify-content-center">
                <div class="col">
                    <h4>Sticker</h4>
                    <div class="card mb-3" style="height:200px;">
                    <div class="m-2 gap-2 overflow-auto">
                        <?php foreach($shirt_stickers as $shirt_sticker) { 
                            $dir = "../images/All/stickers/" . $shirt_sticker['sticker_images'];
                            ?>
                            <button class="btn p-2" style="width:100px; height:100px;"><img src="<?php echo $dir ?>" alt="" style="width:80px; heiht:80px;"></button>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col text-center">
                    <!-- <form id="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="file-input-wrapper">
                            <input type="file" id="file" name="file" class="file-input" accept="image/*">
                            <label for="file" class="file-label" id="file-label">Choose a file</label>
                        </div>
                        <div class="preview" id="preview">
                            <img id="preview-image" src="" alt="Image preview">
                        </div>
                        <button type="submit" class="btn btn-dark">Upload</button>
                    </form> -->
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
                <a href="#" class="btn btn-dark col">Add to cart</a>
            </div>
        </div>
    </div>

    <?php require_once ("./Layout/footer.php") ?>