<div id="logIn-modal" class="modal p-5 <?= !array_key_exists("log-in", $_GET) ? "fade" : "open"; ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5 bg-<?= \Static\Kernel::isLight() ? "light" : "dark"; ?>">
            <h3 class="p-4"> <?= $parameters["getText"]("logIn-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("logIn-content"); ?> </p>
            <form id="logIn-form" class="p-4">
                <input id="logIn-email" class="form-control text-center rounded-pill" type="email" placeholder="<?= $parameters["getText"]("logIn-email"); ?>" required/>
                <input id="logIn-password" class="mt-4 form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("logIn-password"); ?>" required/>
                <input id="logIn-submit" class="w-100 mt-4 btn rounded-pill button-classic" type="submit" value="<?= $parameters["getText"]("logIn-submit"); ?>"/>
                <button id="logIn-reset" class="w-100 my-4 btn rounded-pill button-outline" type="button" data-bs-toggle="modal" data-bs-target="#reset-modal"> <?= $parameters["getText"]("logIn-reset"); ?> </button>
                <button id="logIn-cancel" class="w-100 mt-4 btn rounded-pill button-outline" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("logIn-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>