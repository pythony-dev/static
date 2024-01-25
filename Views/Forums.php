<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("forums-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("forums-content"); ?> </p>
    <?php if(count($parameters["threads"])) { ?>
        <div class="p-5">
            <?php foreach($parameters["threads"] as $id => $thread) { ?>
                <?php if($id != 0) { ?>
                    <div class="line"> </div>
                <?php } ?>
                <a class="text-decoration-none text-<?= \Static\Kernel::isLight() ? "dark" : "light"; ?>" href="<?= $parameters["getPath"]("/thread/" . $thread["hash"]); ?>">
                    <div class="row mx-0">
                        <div class="col-9 col-md-5 my-auto px-0 p<?= $id == 0 ? "b" : ($id == array_key_last($parameters["threads"]) ? "t" : "y"); ?>-5">
                            <div class="d-flex">
                                <img class="my-auto shadow border rounded-circle image-64 ratio-1" src="<?= $thread["image"]; ?>" alt="<?= $thread["author"]; ?>"/>
                                <div class="my-auto ps-4 text-start">
                                    <p class="overflow-hidden mb-0"> <?= $parameters["getText"]("forums-by") . " " . $thread["author"]; ?> </p>
                                    <p class="mb-0"> <?= $parameters["getText"]("forums-" . (str_contains($thread["updated"], "/") ? "on" : "at")) . " " . $thread["updated"]; ?> </p>
                                    <p class="mb-0"> <?= $thread["count"] . " " . $parameters["getText"]("forums-posts"); ?> </p>
                                </div>
                            </div>
                        </div>
                        <div class="order-md-1 col-3 col-md-2 my-auto px-0 p<?= $id == 0 ? "b" : ($id == array_key_last($parameters["threads"]) ? "t" : "y"); ?>-5 text-end">
                            <?php if($parameters["userID"] != $thread["userID"]) { ?>
                                <input class="my-auto btn rounded-circle image-48 ratio-1 button-outline thread-report" type="image" src="<?= $parameters["getPath"]("/Public/Images/Icons/" . (\Static\Kernel::isLight() ? "Light" : "Dark") . "/Report.png"); ?>" alt="<?= $parameters["getText"]("forums-report"); ?>" thread="<?= $thread["hash"]; ?>"/>
                            <?php } else { ?>
                                <input class="my-auto btn rounded-circle image-48 ratio-1 button-outline thread-delete" type="image" src="<?= $parameters["getPath"]("/Public/Images/Icons/" . (\Static\Kernel::isLight() ? "Light" : "Dark") . "/Delete.png"); ?>" alt="<?= $parameters["getText"]("forums-delete"); ?>" thread="<?= $thread["hash"]; ?>"/>
                            <?php } ?>
                        </div>
                        <div class="col-12 col-md-5 my-auto px-0 p<?= $id == 0 ? "b" : ($id == array_key_last($parameters["threads"]) ? "t" : "b-5 pt-md"); ?>-5">
                            <p class="overflow-hidden mb-0 text-justify fw-bold"> <?= $thread["title"]; ?> </p>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="p-5 mb-0"> <?= $parameters["getText"]("forums-empty"); ?> </p>
    <?php } ?>
    <?= Static\Components\Pagination::create($parameters["page"], $parameters["limit"], $parameters["getPath"]("/forums")); ?>
    <div class="p-5">
        <?php if($parameters["userID"] <= 0) { ?>
            <a class="w-100 btn rounded-pill button-normal" href="<?= $parameters["getPath"]("/log-in"); ?>"> <?= $parameters["getText"]("forums-logIn"); ?> </a>
        <?php } else { ?>
            <button class="w-100 btn rounded-pill button-normal" data-bs-toggle="modal" data-bs-target="#create-modal"> <?= $parameters["getText"]("forums-create"); ?> </button>
        <?php } ?>
    </div>
</article>