<?php
require_once("../database/add_to_cart.php");
require_once("../database/invoiceDb.php");
require_once("../database/typeDb.php");
require_once("../database/colorDb.php");
require_once("../database/sizeDb.php");
require_once("../database/stickerDb.php");


$cookie_user = null;
if (isset($_COOKIE['user'])) {
    $cookie_user = json_decode($_COOKIE['user'], true);
}
$id = $cookie_user['id'];
$users = get_user_by_id($mysqli, $id);
$user = $users->fetch_assoc();
$name = $user['name'];
$email = $user['email'];
foreach ($order as $ood) {
    $address = $ood['address'];
    $description = $ood['description'];
}
$iv_id = "";
$created_at = "";
$ords = [];
if (isset($_SESSION['invoice_id'])) {
    $iv_id = $_SESSION['invoice_id'];
    // echo $_SESSION['invoice_id'];
    $orders = get_order_by_invoice_id($mysqli, $_SESSION['invoice_id']);
    // var_dump($orders);
    if ($orders) {
        $ordes = $orders->fetch_all(MYSQLI_ASSOC);
        // var_dump($ordes);
        foreach ($ordes as $ord) {
            $created_at = $ord['created_at'];
            // var_dump($ord);
            array_push($ords, [
                'order_id'          => $ord['order_id'],
                'user_id'           => $ord['user_id'],
                'product_id'        => $ord['product_id'],
                'item_id'           => $ord['item_id'],
                'product_type'      => $ord['product_type'],
                'invoice_id'        => $ord['invoice_id'],
                'order_quantity'    => $ord['order_quantity'],
                'shipping_address'  => $ord['shipping_address'],
                'order_description' => $ord['order_description'],
            ]);
            // var_dump($ords);
        }
    } else {
        echo "No orders found for this invoice ID.";
    }
}
$total = 0;
if (isset($_SESSION['orderTotal'])) {
    foreach ($order_total as $ot) {
        $total = $ot;
    }
}
$close = false;
if (isset($_POST['refresh']) || isset($_POST['download'])) {
    $close = true;
    session_destroy();
    echo "<script>window.location.href ='./carts.php' </script>";
}
?>
<div class="modal fade" id="invoice" aria-hidden="true" aria-labelledby="invoice" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoice">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding-left:150px;">
                <div class="card p-3" id="invoice_data" style="width:90%; height:auto">
                    <div class=" d-flex justify-content-center">
                        <img src="../images/Logo1.png" style="width:80px; height:auto;">
                        <h4 class="py-3">Tee World Myanmar</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="text-secondary text-start">
                            Invoice_ID      : <?php echo $iv_id ?> <br>
                            User_name       : <?php echo $name ?> <br>
                            Email           : <?php echo $email ?> <br>
                            Address         : <?php echo $address ?> <br>
                            Description     : <?php echo $description ?>
                        </p>
                        <p class="text-end text-secondary">
                            Date : <?php echo substr($created_at, 0, 10) ?>
                        </p>
                    </div>
                    <div>
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Order_id</th>
                                    <th scope="col">Products</th>
                                    <th scope="col">Product_name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($ords as $od) {
                                    if ($od['product_id'] != null) {
                                        $o_product = get_product_by_id($mysqli, $od['product_id']);
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $i + 1 ?></th>
                                            <td>
                                                <p><?php echo $od['order_id'] ?></p>
                                            </td>
                                            <td>
                                                <p><?php
                                                    $photos = explode(',', $o_product['product_images']);
                                                    $dir = "../images/All/products/" . $photos[0];
                                                    if (!empty($photos[0])) : ?>
                                                        <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image">
                                                    <?php else : ?>
                                                        <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available">
                                                    <?php endif; ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p><?php echo $o_product['product_name'] ?></p>
                                            </td>
                                            <td>
                                                <p><?php echo $od['order_quantity'] ?></p>
                                            </td>
                                            <td>
                                                <p><?php echo $o_product['product_price'] * $od['order_quantity']  ?> MMK </p>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    if ($od['item_id'] != null) {
                                        $o_item = get_item_by_id($mysqli, $od['item_id']);
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i + 1 ?></th>
                                            <td>
                                                <p><?php echo $od['order_id'] ?></p>
                                            </td>
                                            <td>
                                                <p>
                                                    <?php
                                                    $type_img = (get_type_by_id($mysqli, $o_item['type_id']))->fetch_assoc();
                                                    $photos = explode(',', $type_img['type_images']);
                                                    $dir = "../images/All/types/" . $photos[0];
                                                    if (!empty($photos[0])) :
                                                    ?>
                                                        <img src="<?php echo $dir; ?>" class="rounded border border-1" style="width:100px; height:60px;" alt="Product Image">
                                                    <?php else : ?>
                                                        <img src=<?php echo "../images/All/default_image.jpg" ?> class="rounded ms-2 " style="width:100px; height:60px;" alt="No Image Available">
                                                    <?php endif; ?>
                                                </p>
                                            </td>
                                            <td>
                                                <?php
                                                $o_color = (getColorById($mysqli, $o_item['color_id']))->fetch_assoc();
                                                $o_size = (getSizeById($mysqli, $o_item['size_id']))->fetch_assoc();
                                                ?>
                                                <div class="border border-1 rounded" style="margin-left: 60px; width:30px; height:30px; background-color:<?php echo $o_color['color_name'] ?>"></div>
                                                <div class="border border-1 rounded text-center" style="margin-left: 60px; width:30px; height:30px;"><?php echo $o_size['size'] ?></div>
                                            </td>
                                            <td>
                                                <p><?php echo $od['order_quantity'] ?></p>
                                            </td>
                                            <td>
                                                <p><?php echo $o_item['item_price'] * $od['order_quantity']  ?> MMK </p>
                                            </td>
                                        </tr>
                                <?php
                                $i++;
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="5" class="text-end fs-5 pe-5 fw-bold">All total</td>
                                    <td class="fs-6 fw-bold text-end">
                                        <?php
                                        echo $total;
                                        ?>MMK
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-start">
                        <div class="fs-5">Contact Us</div>
                        <p>ph no <br>
                            address <br>
                            email
                        </p>
                    </div>
                    <div class="text-center">
                        <img src="../images/Thank_you.jpg" style="width:100px; height:auto;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="post">
                    <button type="button" onclick="location.replace('../user/carts.php')" name="refresh" class="btn btn-secondary">Close</button>
                </form>
                <button class="btn btn-dark" name='download' id="download">Dowload invoice</button>
                <button class="d-none" id="close" data-bs-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>
<!-- call global jspdf functions cdn link -->
<!-- Include jsPDF library -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->
<!-- Include html2canvas library -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> -->
<!-- Include jsPDF html2canvas plugin -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.jslibs/jspdf/2.5.1/html2canvas.min.js"></script> -->
<!-- Include jsPDF library from alternative CDN -->
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<!-- Include html2canvas library from alternative CDN -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<!-- <script src="./assets/app.js" defer></script> -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var download = document.getElementById('download');
        // var invoice = document.getElementById('invoice_data');
        window.jsPDF = window.jspdf.jsPDF;

        function download_invoice() {
            const content = document.querySelector("#invoice_data");

            // Use html2canvas to capture the content
            html2canvas(content).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const doc = new jsPDF();

                // Add the captured image to the PDF
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 295; // A4 height in mm
                const imgHeight = 290;
                let heightLeft = imgHeight;

                let position = 0;

                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                doc.save('invoice.pdf');
            });
        }

        download.addEventListener("click", download_invoice);
    });
</script>