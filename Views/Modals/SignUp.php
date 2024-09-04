<div id="signUp-modal" class="modal p-5 <?= !array_key_exists("sign-up", $_GET) ? "fade" : "open"; ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5 bg-<?= \Static\Kernel::isLight() ? "light" : "dark"; ?>">
            <h3 class="p-4"> <?= $parameters["getText"]("signUp-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("signUp-content"); ?> </p>
            <form id="signUp-form" class="p-4">
                <div class="d-flex">
                    <input id="signUp-email" class="w-67 form-control text-center rounded-left" type="email" placeholder="<?= $parameters["getText"]("signUp-email"); ?>" required/>
                    <input id="signUp-confirm" class="w-33 btn rounded-right button-classic" type="button" value="<?= $parameters["getText"]("signUp-confirm"); ?>"/>
                </div>
                <input id="signUp-code" class="d-none mt-4 form-control text-center rounded-pill" type="text" placeholder="<?= $parameters["getText"]("signUp-code"); ?>"/>
                <input id="signUp-username" class="mt-4 form-control text-center rounded-pill" type="text" placeholder="<?= $parameters["getText"]("signUp-username"); ?>" required/>
                <input id="signUp-password" class="mt-4 form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("signUp-password"); ?>" required/>
                <div class="d-flex justify-content-center align-items-center pt-4">
                    <div>
                        <input id="signUp-agree" class="form-check-input rounded-pill" type="checkbox" required/>
                    </div>
                    <label class="ps-3 text-justify" for="signUp-agree"> <?= $parameters["getText"]("signUp-agree", true); ?> </label>
                </div>
                <input class="w-100 my-4 btn rounded-pill button-classic" type="submit" value="<?= $parameters["getText"]("signUp-submit"); ?>"/>
                <button id="signUp-cancel" class="w-100 mt-4 btn rounded-pill button-outline" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("signUp-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>