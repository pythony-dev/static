<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("logIn-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("logIn-content"); ?> </p>
    <form id="logIn-form" class="px-5">
        <input id="logIn-email" class="my-5 form-control text-center" type="email" placeholder="<?= $parameters["getText"]("logIn-email"); ?>" required/>
        <input id="logIn-password" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("logIn-password"); ?>" required/>
        <input class="w-100 btn btn-primary" type="submit" value="<?= $parameters["getText"]("logIn-submit"); ?>"/>
        <button class="w-100 my-5 btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#logIn-reset-modal"> <?= $parameters["getText"]("logIn-reset"); ?> </button>
    </form>
</article>
<div id="logIn-reset-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5">
            <h3 class="p-5"> <?= $parameters["getText"]("logIn-reset"); ?> </h3>
            <form id="logIn-reset-form" class="px-5">
                <input id="logIn-reset-email" class="my-5 form-control text-center" type="email" placeholder="<?= $parameters["getText"]("logIn-reset-email"); ?>" required/>
                <input class="w-100 mb-5 btn btn-primary" type="submit" value="<?= $parameters["getText"]("logIn-reset-submit"); ?>"/>
            </form>
        </div>
    </div>
</div>