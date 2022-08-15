<div id="delete-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5">
            <h3 class="p-4"> <?= $parameters["getText"]("delete-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("delete-content"); ?> </p>
            <form id="delete-form" class="p-4">
                <input id="delete-confirm" class="mb-4 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("delete-confirm"); ?>" required/>
                <input class="w-100 btn btn-danger" type="submit" value="<?= $parameters["getText"]("delete-submit"); ?>"/>
                <button class="w-100 mt-4 btn btn-outline-secondary" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("delete-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>