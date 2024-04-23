<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("privacy-title"); ?> </h1>
    <?php foreach($parameters["privacy"] as $privacy) { ?>
        <h3 class="p-5"> <?= $parameters["getText"]("privacy-" . strtolower($privacy) . "-title"); ?> </h3>
        <p class="p-5 text-justify"> <?= $parameters["getText"]("privacy-" . strtolower($privacy) . "-content", true); ?> </p>
    <?php } ?>
    <div class="p-5">
        <a class="w-100 btn rounded-pill button-classic" href="<?= $parameters["getPath"]("/"); ?>"> <?= $parameters["getText"]("privacy-button"); ?> </a>
    </div>
</article>