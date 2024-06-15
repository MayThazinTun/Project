<?php require_once ("../Layout/header.php") ?>

<div class="row">
    <div class="col-auto">
        <?php require_once ("../Layout/sidebar.php") ?>
    </div>
    <div class="col">
        <div class="card mt-3" style="width:300px; height: auto;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Description</p>
                <div class="row justify-content-center gap-2 px-2">
                    <a href="#" class="btn btn-dark col">Add to cart</a>
                    <a href="#" class="btn btn-dark col">Order</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ("../Layout/footer.php") ?>