<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("welcome-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("welcome-content"); ?> </p>
    <form id="welcome-form" class="p-5">
        <input id="welcome-email" class="mb-5 form-control text-center rounded-pill" type="email" placeholder="<?= $parameters["getText"]("welcome-email"); ?>" required/>
        <input class="w-100 btn rounded-pill button-classic" type="submit" value="<?= $parameters["getText"]("welcome-submit"); ?>"/>
    </form>
</article>