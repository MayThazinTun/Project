<div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow" style="width: 200px; height:100vh">
    <div class="fs-5 ps-3">
        Catagories
    </div>
    <hr>
    <div class="btn-group-vertical gap-2">

        <button class="btn btn-outline-secondary border-0 text-start ps-4"onclick="location.href='./store.php';">All</button>
        <?php
        $categories = get_all_categories($mysqli);
        while ($category = $categories->fetch_assoc()) {
            ?>
            <button class="btn btn-outline-secondary border-0 text-start ps-4"
                onclick="location.href='./store.php?category_id=<?php echo $category['category_id'] ?>';">
                <?php echo $category['category_name'] ?></button>
            <?php
        }
        ?>
        <!-- <button class="btn btn-outline-secondary border-0 text-start ps-4">database</button> -->

    </div>
</div>