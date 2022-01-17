<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("signUp-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("signUp-content"); ?> </p>
    <form id="signUp-form" class="px-5">
        <input id="signUp-email" class="my-5 form-control text-center" type="email" placeholder="<?= $parameters["getText"]("signUp-email"); ?>" required/>
        <input id="signUp-username" class="my-5 form-control text-center" type="text" placeholder="<?= $parameters["getText"]("signUp-username"); ?>" required/>
        <input class="w-100 mb-5 btn btn-primary" type="submit" value="<?= $parameters["getText"]("signUp-submit"); ?>"/>
    </form>
</article>