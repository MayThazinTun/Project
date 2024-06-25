<?php require_once ("./Layout/header.php"); ?>

<div class="row me-1">
    <div class="col-auto">
        <?php require_once ("./Layout/sidebar.php") ?>
    </div>
    <div class="col p-3">
        <div class="row">
            <div class="col-8">
                <div class="card p-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Select All
                        </label>
                    </div>
                    <hr>
                    <!-- list of product that customer add to cart -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            Product
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card p-3">
                    <h5 class="card-title">Order Summary</h5>
                    <hr>
                    <div class="card-text">
                        <p>product type : count price</p>
                        <!-- sometime discount will be include -->
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5>Total</h5>
                            <h5>total price</h5>
                        </div>
                    </div>
                    <div class="d-grid">
                        <?php require_once ("./order.php") ?>
                        <?php require_once ("./buy.php") ?>
                        <?php require_once ("./invoice.php");?>
                        <a class="btn btn-dark" data-bs-toggle="modal" href="#order" role="button">Process
                            to Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ("./Layout/footer.php") ?>