<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("terms-title"); ?> </h1>
    <?php foreach($parameters["terms"] as $terms) { ?>
        <h3 class="p-5"> <?= $parameters["getText"]("terms-" . strtolower($terms) . "-title"); ?> </h3>
        <p class="p-5 text-justify"> <?= $parameters["getText"]("terms-" . strtolower($terms) . "-content", true); ?> </p>
    <?php } ?>
    <div class="p-5">
        <a id="terms-home" class="w-100 btn rounded-pill button-classic" href="<?= $parameters["getPath"]("/"); ?>"> <?= $parameters["getText"]("terms-button"); ?> </a>
    </div>
</article>