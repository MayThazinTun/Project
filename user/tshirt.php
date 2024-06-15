<?php require_once ("../Layout/header.php") ?>

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
            <div class="d-flex justify-content-between">
                <h4>Sticker</h4>
                <input type="file" name="" id="" accept="image/*" class="me-3">
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
                <?php require_once ("./order.php") ?>
                <?php require_once ("./buy.php") ?>
                <?php require_once ("./invoice.php"); ?>
                <a class="col btn btn-dark" data-bs-toggle="modal" href="#order" role="button">Order</a>
            </div>
        </div>
    </div>

    <?php require_once ("../Layout/footer.php") ?>