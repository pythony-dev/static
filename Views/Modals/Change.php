<div id="change-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5">
            <h3 class="p-4"> <?= $parameters["getText"]("change-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("change-content"); ?> </p>
            <form id="change-form" class="p-4">
                <input id="change-password" class="mb-4 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("change-password"); ?>" required/>
                <input id="change-confirm" class="my-4 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("change-confirm"); ?>" required/>
                <input class="w-100 btn btn-primary" type="submit" value="<?= $parameters["getText"]("change-submit"); ?>"/>
                <button class="w-100 mt-4 btn btn-outline-secondary" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("change-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>