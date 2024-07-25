<?php
require_once("./Layout/header.php");
require_once("../database/typeDb.php");
require_once("../database/sizeDb.php");
require_once("../database/colorDb.php");
require_once("../database/stickerDb.php");
require_once("../database/custom_add.php");
require_once("../database/add_to_cart.php");

$shirt_types = get_all_types($mysqli);
$shirt_sizes = get_all_sizes($mysqli);
$shirt_colors = get_all_colors($mysqli);
$shirt_stickers = get_all_stickers($mysqli);
$types_id = $sizes_id = $colors_id = $stickers_id = null;
$qty = 0;



if (isset($_POST['type'])) {

    $types_id = $_POST['type'];
    $result = get_type_by_id($mysqli, $types_id);
    $shirtTypes = $result->fetch_assoc();
    $type = [
        'type_id' => $shirtTypes['type_id'],
        'type_name' => $shirtTypes['type_name'],
        'type_images' => $shirtTypes['type_images'],
        'type_price' => $shirtTypes['type_price']
    ];
    $_SESSION['type'] = $type;
}

if (isset($_POST['colorPick'])) {
    $colorPicker = $_POST['colorPicker'];
    if (getColorByName($mysqli, $colorPicker) != false) {
        $create = getColorByName($mysqli, $colorPicker);
        $color = [
            'color_id' => $create['color_id'],
            'color_name' => $create['color_name']
        ];
    } else {
        if (createColors($mysqli, $colorPicker)) {
            $create = getColorByName($mysqli, $colorPicker);
            $color = [
                'color_id' => $create['color_id'],
                'color_name' => $create['color_name']
            ];
        }
    }
    $_SESSION['color'] = $color;
} else if (isset($_POST['color'])) {
    $colors_id = $_POST['color'];
    $result = getColorById($mysqli, $colors_id);
    $shirtColors = $result->fetch_assoc();
    $color = [
        'color_id' => $shirtColors['color_id'],
        'color_name' => $shirtColors['color_name']
    ];
    $_SESSION['color'] = $color;
}


if (isset($_POST['size'])) {
    $sizes_id = $_POST['size'];
    $result = getSizeById($mysqli, $sizes_id);
    $shirtSize = $result->fetch_assoc();
    $size = [
        'size_id' => $shirtSize['size_id'],
        'size' => $shirtSize['size'],
        'size_price' => $shirtSize['size_price']
    ];

    $_SESSION['size'] = $size;
}
$display = "";
$note = "disabled";
if (isset($_POST['sticker'])) {
    $display = "d-none";
    $note = "";
    $stickers_id = $_POST['sticker'];
    $result = get_sticker_by_id($mysqli, $stickers_id);
    $shirtSticker = $result->fetch_assoc();
    $sticker = [
        'sticker_id' => $shirtSticker['sticker_id'],
        'sticker_images' => $shirtSticker['sticker_images'],
        'sticker_price' => $shirtSticker['sticker_price']
    ];
    $_SESSION['sticker'] = $sticker;
}

if (isset($_POST['qtyb'])) {
    $qty = $_POST['qty'];
    $_SESSION['qty'] = $qty;
}

if (isset($_POST['removeSticker'])) {
    $display = "";
    $sticker = [];
    $_SESSION['sticker'] = $sticker;
}
$shirt_note = "";
if (isset($_POST['note'])) {
    $shirt_note = $_POST['note'];
    $shirtNote  = ['shirt_note' => $shirt_note];
}
$_SESSION['note'] = $shirtNote;
if (isset($_POST['addToCart'])) {
    if (isset($_POST['note'])) {
        $shirt_note = $_POST['note'];
    }

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

            $newFileName = "custom_" . $photo_name;
            $uploadDir = "../images/All/stickers/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $photo_destination = $uploadDir . $newFileName;
            if (move_uploaded_file($photos_tmp[$index], $photo_destination)) {
                $photos_paths[] = $newFileName;
            } else {
                $photos_error = "Error uploading file: " . $photo_name;
                break;
            }
        }
    }

    if (!empty($photos_paths)) {
        $photo_paths_str = implode(",", $photos_paths);

        $stickerPrice = 800;
        if (create_sticker($mysqli, $stickerPrice, $photo_paths_str)) {
            $createSticker = get_sticker_by_sticker($mysqli, $photo_paths_str);
            $sticker = [
                'sticker_id' => $createSticker['sticker_id'],
                'sticker_images' => $createSticker['sticker_images'],
                'sticker_price' => $createSticker['sticker_price']
            ];
        }
        $_SESSION['sticker'] = $sticker;
    }

    if (isset($_SESSION['sticker']) && $_SESSION['sticker'] != []) {
        array_push($shirtCart, [
            'type_id' => $_SESSION['type']['type_id'],
            'type_images' => $_SESSION['type']['type_images'],
            'type_name' => $_SESSION['type']['type_name'],
            'type_price' => $_SESSION['type']['type_price'],
            'color_id' => $_SESSION['color']['color_id'],
            'color_name' => $_SESSION['color']['color_name'],
            'size_id' => $_SESSION['size']['size_id'],
            'size' => $_SESSION['size']['size'],
            'size_price' => $_SESSION['size']['size_price'],
            'sticker_id' => $_SESSION['sticker']['sticker_id'],
            'sticker_images' => $_SESSION['sticker']['sticker_images'],
            'sticker_price' => $_SESSION['sticker']['sticker_price'],
            'note' => $_SESSION['note']['shirt_note'],
            'total_price' => $_SESSION['type']['type_price'] + $_SESSION['size']['size_price'] + $_SESSION['sticker']['sticker_price'],
            'qty' => $_SESSION['qty']
        ]);
    } else {
        array_push($shirtCart, [
            'type_id' => $_SESSION['type']['type_id'],
            'type_images' => $_SESSION['type']['type_images'],
            'type_name' => $_SESSION['type']['type_name'],
            'type_price' => $_SESSION['type']['type_price'],
            'color_id' => $_SESSION['color']['color_id'],
            'color_name' => $_SESSION['color']['color_name'],
            'size_id' => $_SESSION['size']['size_id'],
            'size' => $_SESSION['size']['size'],
            'size_price' => $_SESSION['size']['size_price'],
            'sticker_id' => "",
            'sticker_images' => "",
            'sticker_price' => 0,
            'note' => "",
            'total_price' => $_SESSION['type']['type_price'] + $_SESSION['size']['size_price'],
            'qty' => $_SESSION['qty']
        ]);
    }
    unset($_SESSION['type']);
    unset($_SESSION['color']);
    unset($_SESSION['size']);
    unset($_SESSION['sticker']);
    unset($_SESSION['qty']);
    $qty = 0;
    // var_dump($shirtCart);
    $_SESSION['shirtCart'] = $shirtCart;
}

?>

<div class="row justify-content-center">
    <div class="col-8 ps-4 pe-2">
        <div class="card p-3 my-3 shadow">
            <form method="post" enctype="multipart/form-data">
                <!-- choose shirt type -->
                <div>
                    <h4>Type</h4>

                    <div class="row overflow-auto types" style="height:200px">
                        <?php
                        if ($shirt_types != false) {
                            for ($i = 0; $i < count($shirt_types); $i++) {
                                $dir = "../images/All/types/" . $shirt_types[$i]['type_images'];
                        ?>
                                <div class="d-grid justify-content-center col-3 mx-3">
                                    <img src="<?php echo $dir ?>" class="border border-2 mx-3" style="width:250px; height:150px;">

                                    <button class="btn btn-outline-dark my-2 mx-3" name="type" type="submit" value="<?php echo $shirt_types[$i]['type_id'] ?>"><?php echo $shirt_types[$i]['type_name'] ?></button>
                                    <!-- <input type="text" name="type_id" value="" style="visibility: hidden; width: 0; height: 0;"> -->
                                </div>

                        <?php }
                        } ?>

                    </div>

                </div>
                <hr>
                <!-- choose color -->
                <div>
                    <h4>Colors</h4>
                    <div class="row justify-content-center">
                        <div class="col-7">
                            <div class="card" style="height:200px;">
                                <div class="m-2 gap-2 overflow-auto types">
                                    <?php
                                    if ($shirt_colors != false) {
                                        foreach ($shirt_colors as $shirt_color) { ?>
                                            <button class="btn mt-2" value="<?php echo $shirt_color['color_id'] ?>" name="color" style="background-color:<?php echo $shirt_color['color_name'] ?>; width:50px; height:50px;"></button>
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
                            <button class="btn btn-outline-secondary" name="colorPick">Submit</button>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- choose size -->
                <div>
                    <h4>Size</h4>
                    <div class="d-flex overflow-auto gap-2">
                        <?php
                        if ($shirt_sizes != false) {
                            foreach ($shirt_sizes as $shirt_size) { ?>
                                <button class="btn btn-outline-dark" value="<?php echo $shirt_size['size_id'] ?>" name="size">
                                    <?php echo $shirt_size['size'] ?>
                                </button>
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
                                <div class="row m-2 gap-3 overflow-auto types">
                                    <?php
                                    if ($shirt_stickers != false) {
                                        foreach ($shirt_stickers as $shirt_sticker) {
                                            if (!str_contains($shirt_sticker['sticker_images'], 'custom_')) {


                                                $dir = "../images/All/stickers/" . $shirt_sticker['sticker_images'];
                                    ?>
                                                <button class="col-2 btn p-2 m-2" style="width:100px; height:100px;" name="sticker" value="<?php echo $shirt_sticker['sticker_id'] ?>">
                                                    <img src="<?php echo $dir ?>" alt="" style="width:80px; heiht:80px;"></button>
                                    <?php }
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-4 p-3">
        <div class="card p-3 shadow">
            <form method="post" enctype="multipart/form-data">
                <div class="d-flex justify-content-between">
                    <h3>Choose your type</h3>
                </div>
                <hr>
                <div class="overflow-auto types">
                    <div class="card" style="height: 200px;">
                        <?php
                        if (isset($_SESSION['type'])) {
                            $type = $_SESSION['type'];
                            $dir = "../images/All/types/" . $type['type_images'];
                        ?>
                            <div class="text-center">
                                <img src="<?php echo $dir ?>" alt="" class="my-2" style="height:11rem; max-width: 14rem;">
                            </div>
                        <?php
                        } ?>
                    </div>
                    <div class="row my-2 justify-content-around">
                        <div class="col-auto d-flex border border-1 py-1">
                            Color:
                            <?php
                            if (isset($_SESSION['color'])) {
                            ?>
                                <div class="border border-1 rounded" style="width:70px; height:30px; background-color:<?php echo $_SESSION['color']['color_name'] ?>">
                                </div> <?php
                                    }
                                        ?>
                        </div>
                        <div class="col-auto d-flex border border-1 py-1">
                            Size :
                            <?php
                            if (isset($_SESSION['size'])) {
                                echo $_SESSION['size']['size'];
                            } ?>
                        </div>
                        <div class="col-auto border border-1 py-1">
                            <div class=" d-flex">
                                <label for="qty">Qty &nbsp; </label>
                                <input type="number" name="qty" id="qty" class="mt-1" style="width:50px; height:25px;" value="<?php echo $qty ?>">
                                <button class="btn btn-outline-secondary mt-1 border-0" name='qtyb'>
                                    <i class="fa-solid fa-check" style="color: #c0c0c0;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="d-flex justify-content-between">
                            <h5>Sticker </h5>
                            <button class="btn btn-outline-secondary border-0" name="removeSticker"><i class="fa-solid fa-trash-can" style="color: #98999a;"></i></button>

                        </div>
                        <div class="card" style="height:150px;">
                            <?php
                            if (isset($_SESSION['sticker']) && $_SESSION['sticker'] != []) {
                                $sticker = $_SESSION['sticker'];
                                $dir = "../images/All/stickers/" . $sticker['sticker_images'];
                            ?>
                                <div class="text-center">
                                    <img src="<?php echo $dir; ?>" alt="" style="max-width: 14rem; height:140px;">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <input type="file" name="images[]" id="upload_image" accept="image/*" class="form-control <?php echo $display ?>" style="">
                    </div>
                    <div class="my-2">
                        <h5>Add Note for sticker placement</h5>
                        <textarea name="note" style="width:100%; height:100px;" class="border border-secondary" <?php echo $note; ?>> <?php echo $shirt_note; ?></textarea>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between text-secondary">
                        <?php if (isset($_SESSION['type'])) { ?>
                            <h5>Type_price</h5>
                            <h5> <?php echo $_SESSION['type']['type_price'] ?></h5>
                        <?php } ?>
                    </div>
                    <div class="d-flex justify-content-between text-secondary">
                        <?php if (isset($_SESSION['size'])) { ?>
                            <h5>Size_price</h5>
                            <h5> <?php echo $_SESSION['size']['size_price'] ?></h5>
                        <?php } ?>
                    </div>
                    <div class="d-flex justify-content-between text-secondary">
                        <?php if (isset($_SESSION['sticker']) && $_SESSION['sticker'] != []) { ?>
                            <h5>Sticker_price</h5>
                            <h5> <?php echo $_SESSION['sticker']['sticker_price'] ?></h5>
                        <?php } ?>
                    </div>
                    <div class="d-flex justify-content-between text-secondary">
                        <?php if (isset($_POST['qty'])) { ?>
                            <h5>Qty</h5>
                            <h5> <?php echo $_POST['qty'] ?></h5>
                        <?php } ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4>Total Price</h4>
                        <?php
                        $disabled = "disabled";
                        if (isset($_SESSION['type']) && isset($_SESSION['size']) && isset($_POST['qty'])) {
                            $disabled = "";
                            if ((isset($_SESSION['sticker']) && $_SESSION['sticker'] != [])) {
                        ?>
                                <h5><?php echo ($_SESSION['type']['type_price'] + $_SESSION['size']['size_price'] + $_SESSION['sticker']['sticker_price']) * $_POST['qty']; ?>
                                    MMK
                                </h5>
                            <?php
                            } else {
                            ?>
                                <h5><?php echo ($_SESSION['type']['type_price'] + $_SESSION['size']['size_price']) * $_POST['qty']; ?>
                                    MMK
                                </h5>
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="row justify-content-center gap-2 px-2 py-2">

                    <button onclick="location.replace('./tshirt.php')" class="btn btn-dark col" name="addToCart" <?php echo $disabled ?>>Add to
                        cart</button>

                </div>
            </form>
        </div>

    </div>
</div>

<?php require_once("./Layout/footer.php") ?>