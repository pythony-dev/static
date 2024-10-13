<div id="reset-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5 bg-<?= \Static\Kernel::isLight() ? "light" : "dark"; ?>">
            <h3 class="p-4"> <?= $parameters["getText"]("reset-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("reset-content"); ?> </p>
            <form id="reset-form" class="p-4">
                <div class="d-flex">
                    <input id="reset-email" class="w-67 form-control text-center rounded-left" type="email" placeholder="<?= $parameters["getText"]("reset-email"); ?>" required/>
                    <input id="reset-confirm" class="w-33 btn rounded-right button-classic" type="button" value="<?= $parameters["getText"]("reset-confirm"); ?>"/>
                </div>
                <input id="reset-code" class="d-none mt-4 form-control text-center rounded-pill" type="text" placeholder="<?= $parameters["getText"]("reset-code"); ?>"/>
                <input id="reset-password" class="mt-4 form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("reset-password"); ?>" required/>
                <input id="reset-submit" class="w-100 my-4 btn rounded-pill button-classic" type="submit" value="<?= $parameters["getText"]("reset-submit"); ?>"/>
                <button id="reset-cancel" class="w-100 mt-4 btn rounded-pill button-outline" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("reset-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>