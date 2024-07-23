<?php
require_once('../layouts/adminHeader.php');
require_once('../../database/orderDb.php');
require_once('../../database/invoiceDb.php');

$invoice_list = (get_all_invoices($mysqli))->fetch_all(MYSQLI_ASSOC);
// var_dump($invoice_list);

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

$total_products = get_total_invoice_count($mysqli, $search);

?>
<div class="container mt-2">
    <h1 class="text-center">Invoices List</h1>
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
                    <th scope="col">Invoice_ID</th>
                    <th scope="col">User_ID</th>
                    <th scope="col">Order_ID</th>
                    <th scope="col">Invoice_total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($invoice_list as $il) {
                    // echo $il['invoice_id'];
                    if(get_order_by_invoice_id($mysqli, $il['invoice_id'])){
                    $order_id = (get_order_by_invoice_id($mysqli, $il['invoice_id']))->fetch_all(MYSQLI_ASSOC);
                    }
                    // echo '<pre>';
                    // var_dump($order_id);
                ?>
                    <tr>
                        <td scope="col"><?php echo $il['invoice_id'] ?></td>
                        <td scope="col"><?php echo $order_id[0]['user_id'] ?></td>
                        <td scope="col"><?php echo $order_id[0]['order_id'] ?></td>
                        <td scope="col"><?php echo $il['total_amount'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<?php require_once('../layouts/adminFooter.php'); ?>