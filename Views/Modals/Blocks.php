<div id="blocks-modal" class="modal p-5 <?= !array_key_exists("blocks", $_GET) ? "fade" : "open"; ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5">
            <h3 class="p-4"> <?= $parameters["getText"]("blocks-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("blocks-content"); ?> </p>
            <?php foreach($parameters["blocks"] as $id => $block) { ?>
                <div class="px-4">
                    <?php if($id != 0) { ?>
                        <div class="line"> </div>
                    <?php } ?>
                    <div class="d-flex justify-content-between py-4">
                        <img class="my-auto shadow border rounded-circle image-64 ratio-1" src="<?= $parameters["getPath"]("/Public/Images/Users/" . \Static\Kernel::getHash("User", $block["userID"]) . ".jpeg?" . time()); ?>" alt="<?= $block["username"]; ?>"/>
                        <p class="my-auto"> <?= $block["username"]; ?> </p>
                        <div class="my-auto">
                            <button class="w-100 btn btn-outline-secondary block-delete" user="<?= \Static\Kernel::getHash("User", $block["userID"]); ?>"> <?= $parameters["getText"]("blocks-unblock"); ?> </button>
                        </div>
                    </div>
                </div>
            <?php } if(!count($parameters["blocks"])) { ?>
                <p class="p-4 mb-0"> <?= $parameters["getText"]("blocks-empty"); ?> </p>
            <?php } ?>
            <div class="p-4">
                <button class="w-100 btn btn-outline-secondary" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("blocks-cancel"); ?> </button>
            </div>
        </div>
    </div>
</div>