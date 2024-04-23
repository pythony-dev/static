<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("signUp-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("signUp-content"); ?> </p>
    <form id="signUp-form" class="p-5">
        <div class="d-flex">
            <input id="signUp-email" class="w-67 form-control text-center rounded-left" type="email" placeholder="<?= $parameters["getText"]("signUp-email"); ?>" required/>
            <input id="signUp-confirm" class="w-33 btn rounded-right button-classic" type="button" value="<?= $parameters["getText"]("signUp-confirm"); ?>"/>
        </div>
        <input id="signUp-code" class="d-none mt-5 form-control text-center rounded-pill" type="text" placeholder="<?= $parameters["getText"]("signUp-code"); ?>"/>
        <input id="signUp-username" class="mt-5 form-control text-center rounded-pill" type="text" placeholder="<?= $parameters["getText"]("signUp-username"); ?>" required/>
        <input id="signUp-password" class="mt-5 form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("signUp-password"); ?>" required/>
        <div class="d-flex justify-content-center align-items-center py-5">
            <div>
                <input id="signUp-agree" class="form-check-input rounded-pill" type="checkbox" required/>
            </div>
            <label class="ps-4 text-justify" for="signUp-agree"> <?= $parameters["getText"]("signUp-agree", true); ?> </label>
        </div>
        <input class="w-100 btn rounded-pill button-classic" type="submit" value="<?= $parameters["getText"]("signUp-submit"); ?>"/>
    </form>
</article>