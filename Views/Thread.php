<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["title"]; ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("thread-content"); ?> </p>
    <div class="p-5">
        <?php foreach($parameters["posts"] as $id => $post) { ?>
            <?php if($id != 0) { ?>
                <div class="line"> </div>
            <?php } ?>
            <div class="d-flex justify-content-between p<?= $id != 0 ? "y" : "b"; ?>-5">
                <div class="d-flex">
                    <img class="my-auto shadow border rounded-circle image-64 ratio-1" src="<?= $post["user"]; ?>" alt="<?= $post["username"]; ?>"/>
                    <div class="my-auto ps-4 text-start">
                        <p class="mb-0"> <?= $parameters["getText"]("thread-by") . " " . $post["username"]; ?> </p>
                        <p class="mb-0"> <?= $parameters["getText"]("thread-on") . " " . $post["date"]; ?> </p>
                        <p class="mb-0"> <?= $parameters["getText"]("thread-at") . " " . $post["time"]; ?> </p>
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row-reverse">
                    <?php if($parameters["userID"] != $post["userID"]) { ?>
                        <div class="my-auto">
                            <input class="btn btn-outline-warning rounded-circle image-48 ratio-1 post-report" type="image" src="<?= $parameters["getPath"]("/Public/Images/Icons/Report.png"); ?>" alt="<?= $parameters["getText"]("thread-report"); ?>" post="<?= $post["hash"]; ?>"/>
                        </div>
                        <?php if($post["chat"]) { ?>
                            <a class="my-auto me-md-4 mt-4 mt-md-auto" href="<?= $post["chat"]; ?>">
                                <input class="btn btn-outline-success rounded-circle image-48 ratio-1" type="image" src="<?= $parameters["getPath"]("/Public/Images/Icons/Chat.png"); ?>" alt="<?= $parameters["getText"]("thread-chat"); ?>"/>
                            </a>
                        <?php } ?>
                    <?php } else if($id != 0) { ?>
                        <div class="my-auto">
                            <input class="btn btn-outline-danger rounded-circle image-48 ratio-1 post-delete" type="image" src="<?= $parameters["getPath"]("/Public/Images/Icons/Delete.png"); ?>" alt="<?= $parameters["getText"]("thread-delete"); ?>" post="<?= $post["hash"]; ?>"/>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row mx-0<?= $id != count($parameters["posts"]) - 1 ? " pb-5" : null; ?>">
                <div class="col-12<?= !$post["image"] ? null : " col-md-8 pe-md-4"; ?> px-0 my-auto">
                    <p class="overflow-hidden mb-0 text-justify"> <?= nl2br($post["message"]); ?> </p>
                </div>
                <?php if($post["image"]) { ?>
                    <div class="col-12 col-md-4 px-0 pt-5 pt-md-0 ps-md-4 my-auto">
                        <img class="img-fluid shadow border rounded ratio-1" src="<?= $post["image"]; ?>" alt="<?= $parameters["title"]; ?>"/>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <?= Static\Components\Pagination::create($parameters["page"], $parameters["limit"], $parameters["getPath"]("/thread/" . $parameters["link"])); ?>
    <div class="p-5">
        <?php if($parameters["userID"] < 1) { ?>
            <a class="w-100 btn btn-primary" href="<?= $parameters["getPath"]("/log-in"); ?>"> <?= $parameters["getText"]("thread-logIn"); ?> </a>
        <?php } else { ?>
            <button class="w-100 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#create-modal"> <?= $parameters["getText"]("thread-create"); ?> </button>
        <?php } ?>
        <a class="w-100 mt-5 btn btn-outline-secondary" href="<?= $parameters["getPath"]("/forums"); ?>"> <?= $parameters["getText"]("thread-back"); ?> </a>
    </div>
</article>