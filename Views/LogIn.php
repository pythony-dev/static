<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("logIn-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("logIn-content"); ?> </p>
    <form id="logIn-form" class="p-5">
        <input id="logIn-email" class="mb-5 form-control text-center rounded-pill" type="email" placeholder="<?= $parameters["getText"]("logIn-email"); ?>" required/>
        <input id="logIn-password" class="my-5 form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("logIn-password"); ?>" required/>
        <input class="w-100 mb-5 btn rounded-pill button-classic" type="submit" value="<?= $parameters["getText"]("logIn-submit"); ?>"/>
        <button class="w-100 mt-5 btn rounded-pill button-outline" type="button" data-bs-toggle="modal" data-bs-target="#reset-modal"> <?= $parameters["getText"]("logIn-reset"); ?> </button>
    </form>
</article>