<?php require_once ("../Login/header.php") ?>

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
                    <!-- Button trigger modal -->
                    <button type="button" class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">
                        Add to cart
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
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
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <a href="../Register/signin.php" class="btn btn-dark">OK</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="col btn btn-dark" data-bs-toggle="modal" data-bs-target="#login">Order</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ("../Login/footer.php") ?>