<?php require_once ("./Layout/header.php") ?>

<div class="row">
    <div class="col-auto">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 200px; height:92vh">
            <div class="fs-5 ps-3">
                DATES
            </div>
            <hr>
            <div class="btn-group-vertical gap-2">

                <button class="btn btn-outline-secondary border-0 text-start ps-4">All</button>

                <button class="btn btn-outline-secondary border-0 text-start ps-4">Today</button>

                <button class="btn btn-outline-secondary border-0 text-start ps-4">Yesterday</button>

                <button class="btn btn-outline-secondary border-0 text-start ps-4">This week</button>

                <button class="btn btn-outline-secondary border-0 text-start ps-4">Last week</button>

                <button class="btn btn-outline-secondary border-0 text-start ps-4">This month</button>

                <button class="btn btn-outline-secondary border-0 text-start ps-4">Last month</button>

                <button class="btn btn-outline-secondary border-0 text-start ps-4">This year</button>

            </div>
        </div>
    </div>
    <div class="col">
        invoice history
    </div>
</div>

<?php require_once ("./Layout/footer.php") ?>