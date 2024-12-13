<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("title-error") . " " . $parameters["error"]; ?> </h1>
    <p class="p-5"> <?= $parameters["response"]; ?> </p>
    <div class="p-5">
        <a class="w-100 btn rounded-pill button-classic" href="<?= $parameters["getPath"]("/"); ?>"> <?= $parameters["getText"]("error-button"); ?> </a>
    </div>
</article>