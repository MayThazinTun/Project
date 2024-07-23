<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/orderDb.php');
require_once('../../database/productDb.php');
require_once('../../database/itemDb.php');
require_once('../../database/typeDb.php');
require_once('../../database/colorDb.php');
require_once('../../database/sizeDb.php');
require_once('../../database/stickerDb.php');

$orders_list = (get_all_orders($mysqli))->fetch_all(MYSQLI_ASSOC);

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

$total_products = get_total_order_count($mysqli, $search);
?>
<div class="container mt-2">
    <h1 class="text-center">Orders List</h1>
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
                    <th scope="col">Order_ID</th>
                    <th scope="col">User_ID</th>
                    <th scope="col">Product</th>
                    <th scope="col">Customized_ID</th>
                    <th scope="col">Types</th>
                    <th scope="col">Invoice_ID</th>
                    <th scope="col">Shipping_address</th>
                    <th scope="col">Order_description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($orders_list as $ol) {
                    if ($ol['product_id'] != null) {
                        $o_product = get_product_by_id($mysqli, $ol['product_id']);
                    } else {
                        $o_product = false;
                    }
                ?>
                    <tr>
                        <td scope="col"><?php echo $ol['order_id'] ?></td>
                        <td scope="col"><?php echo $ol['user_id'] ?></td>
                        <td scope="col">
                            <?php
                            if ($o_product) {
                                $photos = explode(',', $o_product['product_images']);
                                $dir = "../../images/All/products/" . $photos[0];
                                if (!empty($photos[0])) : ?>
                                    <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image"> <br>
                                <?php else : ?>
                                    <img src=<?php echo "../../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available"> <br>
                                <?php endif;
                            } else { ?>
                                -
                            <?php
                            }
                            ?>
                        </td>
                        <td scope="col">
                            <?php
                            if ($ol['item_id'] != null) { 
                                echo $ol['item_id'];
                            } else {?>
                                -
                            <?php
                                ;
                            }
                            ?>
                        </td>
                        <td scope="col">
                            <?php if($ol['product_type'] == 'item'){ ?>
                                Customized products
                            <?php }else{  echo $ol['product_type']; } ?>
                        </td>
                        <td scope="col"><?php echo $ol['invoice_id'] ?></td>
                        <td scope="col"><?php echo $ol['shipping_address'] ?></td>
                        <td scope="col"><?php echo $ol['order_description'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<?php require_once('../layouts/adminFooter.php'); ?>