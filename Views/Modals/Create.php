<div id="create-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5 bg-<?= \Static\Kernel::isLight() ? "light" : "dark"; ?>">
            <?php $type = \Static\Kernel::getRoute() == "Forums" ? "thread" : (\Static\Kernel::getRoute() == "Thread" ? "post" : "message"); ?>
            <h3 class="p-4"> <?= $parameters["getText"]("create-title-" . $type); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("create-content-" . $type); ?> </p>
            <form id="create-form" class="p-4">
                <input id="create-type" class="d-none" value="<?= $type; ?>s"/>
                <?php if(\Static\Kernel::getRoute() == "Forums") { ?>
                    <input id="create-title" class="mb-4 form-control text-center rounded-pill" placeholder="<?= $parameters["getText"]("create-title"); ?>" required/>
                <?php } else { ?>
                    <input id="create-link" class="d-none" value="<?= $parameters["link"]; ?>"/>
                <?php } ?>
                <textarea id="create-message" class="form-control text-center rounded-textarea" placeholder="<?= $parameters["getText"]("create-message"); ?>" rows="5" required></textarea>
                <button id="create-add" class="w-100 mt-4 btn rounded-pill button-outline" type="button"> <?= $parameters["getText"]("create-add"); ?> </button>
                <input id="create-input" class="d-none" type="file" accept=".jpg, .jpeg, .png"/>
                <input id="create-value" class="d-none"/>
                <img id="create-image" class="d-none mt-4 img-fluid shadow border rounded image-256 ratio-1 pointer" alt="#"/>
                <div id="create-spinner" class="d-none mt-4 spinner-border"> </div>
                <input id="create-submit" class="w-100 my-4 btn rounded-pill button-classic" type="submit" value="<?= $parameters["getText"]("create-submit"); ?>"/>
                <button id="create-cancel" class="w-100 mt-4 btn rounded-pill button-outline" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("create-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>