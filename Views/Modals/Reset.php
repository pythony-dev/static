<div id="reset-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5">
            <h3 class="p-4"> <?= $parameters["getText"]("reset-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("reset-content"); ?> </p>
            <form id="reset-form" class="p-4">
                <input id="reset-email" class="mb-4 form-control text-center" type="email" placeholder="<?= $parameters["getText"]("reset-email"); ?>" required/>
                <input class="w-100 my-4 btn btn-primary" type="submit" value="<?= $parameters["getText"]("reset-submit"); ?>"/>
                <button class="w-100 mt-4 btn btn-outline-secondary" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("reset-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>