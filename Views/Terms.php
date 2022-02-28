<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("terms-title"); ?> </h1>
    <?php foreach($parameters["terms"] as $terms) { ?>
        <p class="h3 p-5 fw-bold"> <?= $parameters["getText"]("terms-" . strtolower($terms) . "-title"); ?> </p>
        <p class="p-5 text-justify"> <?= $parameters["getText"]("terms-" . strtolower($terms) . "-content", true); ?> </p>
    <?php } ?>
</article>