<div id="delete-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5 bg-<?= \Static\Kernel::isLight() ? "light" : "dark"; ?>">
            <h3 class="p-4"> <?= $parameters["getText"]("delete-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("delete-content"); ?> </p>
            <form id="delete-form" class="p-4">
                <input id="delete-confirm" class="form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("delete-confirm"); ?>" required/>
                <input class="w-100 my-4 btn rounded-pill button-normal" type="submit" value="<?= $parameters["getText"]("delete-submit"); ?>"/>
                <button class="w-100 mt-4 btn rounded-pill button-outline" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("delete-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>