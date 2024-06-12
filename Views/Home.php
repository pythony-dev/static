<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 text-uppercase fw-bold zoom"> <?= $parameters["getSettings"]("name"); ?> </h1>
    <h2 class="p-5 fw-bold"> <?= $parameters["getText"]("home-title"); ?> </h2>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("home-content"); ?> </p>
    <div class="p-5">
        <a class="w-100 btn rounded-pill button-classic" href="<?= $parameters["getPath"]("/?sign-up"); ?>"> <?= $parameters["getText"]("home-button"); ?> </a>
    </div>
    <?php foreach($parameters["themes"] as $id => $theme) {
        if(!in_array($theme, $parameters["charts"])) echo \Static\Components\Article::create($id, $parameters["getPath"]("/Public/Images/Home/" . (\Static\Kernel::isLight() ? "Light" : "Dark") . "/" . $theme . ".png"), $parameters["getText"]("home-" . strtolower($theme) . "-title"), $parameters["getText"]("home-" . strtolower($theme) . "-content"));
        else { ?>
            <div class="d-md-none p-5">
                <div class="line"> </div>
            </div>
            <h3 class="px-5 pt-5 pb-4"> <?= $parameters["getText"]("home-" . lcfirst($theme) . "-title"); ?> </h3>
            <p class="px-5 py-4 text-justify"> <?= $parameters["getText"]("home-" . lcfirst($theme) . "-content"); ?> </p>
            <canvas id="home-<?= lcfirst($theme); ?>" class="px-5 pb-5 pt-4"> </canvas>
        <?php } ?>
    <?php } ?>
    <div class="p-5">
        <a class="w-100 btn rounded-pill button-classic" href="<?= $parameters["getPath"]("/?sign-up"); ?>"> <?= $parameters["getText"]("home-button"); ?> </a>
    </div>
</article>