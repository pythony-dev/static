<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("features-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("features-content"); ?> </p>
    <div class="row mx-0">
        <?php foreach(range(1, 10) as $feature) { ?>
            <div class="col-12 col-md-6 px-0">
                <div class="p-5">
                    <?= \Static\Components\Card::create(\Static\Kernel::getPath("/Public/Images/Features/" . \Static\Kernel::getHash("Feature", $feature) . ".jpeg"), $parameters["getText"]("features-" . $feature . "-title"), $parameters["getText"]("features-" . $feature . "-subtitle"), $parameters["getText"]("features-" . $feature . "-content")); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</article>