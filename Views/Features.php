<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("features-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("features-content"); ?> </p>
    <div class="row mx-0 px-5">
        <?php foreach($parameters["features"] as $feature) { ?>
            <div class="col-12 col-md-6 col-xl-4 py-4">
                <?= \Static\Components\Card::create($feature["image"], $feature["title"], $feature["subtitle"], $feature["content"]); ?>
            </div>
        <?php } ?>
    </div>
</article>