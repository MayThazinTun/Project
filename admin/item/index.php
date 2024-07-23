<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/itemDb.php');
require_once('../../database/typeDb.php');
require_once('../../database/colorDb.php');
require_once('../../database/sizeDb.php');
require_once('../../database/stickerDb.php');

$customized_products = (get_all_items($mysqli))->fetch_all(MYSQLI_ASSOC);
$customized_product = (getAllitems($mysqli))->fetch_all(MYSQLI_ASSOC);
// var_dump($customized_products);

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

$total_products = get_total_item_count($mysqli, $search);

?>
<div class="container mt-2">
    <h1 class="text-center">Customized Products List</h1>
    <div class="d-flex justify-content-between mb-2">
        <!-- <a href="./create.php" class="btn btn-primary">Create&nbsp;New&nbsp;<i class="fas fa-user-plus"></i></a> -->
        <!-- Search Form -->
        <form method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>" style="width: 150px;">
            <button type="submit" class="btn btn-primary me-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            <a href="index.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i></a>
        </form>
    </div>
    <div class="table-responsive" style="height: 500px;">
        <table class="table table-striped table-bordered my-4 text-center">
            <thead>
                <tr>
                    <th scope="col">Product_ID</th>
                    <th scope="col">Type</th>
                    <th scope="col">Color</th>
                    <th scope="col">Size</th>
                    <th scope="col">Stickers</th>
                    <th scope="col">Price</th>
                    <th scope="col">Order_Quantity</th>
                    <th scope="col">Note</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($customized_products as $c_p) {
                    // echo $c_p['type_id'];
                    $c_type = (get_type_by_id($mysqli, $c_p['type_id']))->fetch_assoc();
                    $c_color = (getColorById($mysqli, $c_p['color_id']))->fetch_assoc();
                    $c_size = (getSizeById($mysqli, $c_p['size_id']))->fetch_assoc();
                    $c_sticker = (get_sticker_by_id($mysqli, $c_p['sticker_id']))->fetch_assoc();
                ?>
                    <!-- <tr>
                        <td class="align-middle"><?php echo $c_p['item_id'] ?></td>
                        <td class="align-middle">
                            <?php
                            $photos = explode(',', $c_type['type_images']);
                            $dir = "../../images/All/types/" . $photos[0];
                            if (!empty($photos[0])) : ?>
                                <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image"> <br>
                            <?php else : ?>
                                <img src=<?php echo "../../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available"> <br>
                            <?php endif;
                            echo $c_type['type_name'];
                            ?>
                        </td>
                        <td class="align-middle">
                            <div class="border border-1 rounded" style="margin-left: 60px; width:30px; height:30px; background-color:<?php echo $c_color['color_name'] ?>"></div>
                        </td>
                        <td class="align-middle">
                            <?php
                            echo $c_size['size'];
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                            $photos = explode(',', $c_sticker['sticker_images']);
                            $dir = "../../images/All/stickers/" . $photos[0];
                            if (!empty($photos[0])) : ?>
                                <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image"> <br>
                            <?php else : ?>
                                <img src=<?php echo "../../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available"> <br>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle"><?php echo $c_p['item_price'] ?></td>
                        <td class="align-middle"><?php echo $c_p['item_quantity'] ?></td>
                        <td class="align-middle"><?php echo $c_p['item_note'] ?></td>
                    </tr> -->
                <?php
                }
                ?>
                <?php
                foreach ($customized_product as $c_p) {
                    // echo $c_p['type_id'];
                    $c_type = (get_type_by_id($mysqli, $c_p['type_id']))->fetch_assoc();
                    $c_color = (getColorById($mysqli, $c_p['color_id']))->fetch_assoc();
                    $c_size = (getSizeById($mysqli, $c_p['size_id']))->fetch_assoc();
                    if ($c_p['sticker_id'] != null) {
                        $c_sticker = (get_sticker_by_id($mysqli, $c_p['sticker_id']))->fetch_assoc();
                    } else {
                        $c_sticker = false;
                    }
                ?>
                    <tr>
                        <td class="align-middle"><?php echo $c_p['item_id'] ?></td>
                        <td class="align-middle">
                            <?php
                            $photos = explode(',', $c_type['type_images']);
                            $dir = "../../images/All/types/" . $photos[0];
                            if (!empty($photos[0])) : ?>
                                <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image"> <br>
                            <?php else : ?>
                                <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available"> <br>
                            <?php endif;
                            echo $c_type['type_name'];
                            ?>
                        </td>
                        <td class="align-middle">
                            <div class="border border-1 rounded" style="margin-left: 60px; width:30px; height:30px; background-color:<?php echo $c_color['color_name'] ?>"></div>
                        </td>
                        <td class="align-middle">
                            <?php
                            echo $c_size['size'];
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                            if($c_sticker){
                            $photos = explode(',', $c_sticker['sticker_images']);
                            $dir = "../../images/All/stickers/" . $photos[0];
                            if (!empty($photos[0])) : ?>
                                <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image"> <br>
                            <?php else : ?>
                                <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available"> <br>
                            <?php endif; }
                            else { ?>
                             No sticker include!
                             <?php 
                            }
                            ?>
                        </td>
                        <td class="align-middle"><?php echo $c_p['item_price'] ?></td>
                        <td class="align-middle"><?php echo $c_p['item_quantity'] ?></td>
                        <td class="align-middle"><?php echo $c_p['item_note'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<?php require_once('../layouts/adminFooter.php'); ?>