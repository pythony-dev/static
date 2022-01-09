<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold zoom"> <?= $parameters["getText"]("home-main-title"); ?> </h1>
    <h2 class="p-5 fw-bold"> <?= $parameters["getText"]("home-main-subtitle"); ?> </h2>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("home-main-content"); ?> </p>
    <?php foreach($parameters["themes"] as $id => $theme) { ?>
        <div class="row<?= $id % 2 ? " flex-row-reverse" : ""; ?> px-5">
            <?php if($id != 0) { ?>
                <div class="d-md-none mx-auto my-5 line"> </div>
            <?php } ?>
            <div class="col-12 col-md-6 py-5 my-auto">
                <img class="img-fluid" src="<?= $parameters["getPath"]("/Public/Images/Home/" . $theme . ".png"); ?>" alt="<?= $theme; ?>"/>
            </div>
            <div class="col-12 col-md-6 py-5 px-md-5 my-auto">
                <h3 class="py-4"> <?= $parameters["getText"]("home-" . lcfirst($theme) . "-title"); ?> </h3>
                <p class="py-4 text-justify"> <?= $parameters["getText"]("home-" . lcfirst($theme) . "-content"); ?> </p>
            </div>
        </div>
    <?php } ?>
    <div class="p-5">
        <a class="w-100 btn btn-primary" href="https://github.com/pythony-dev/static" target="_blank" rel="noopener"> <?= $parameters["getText"]("home-download"); ?> </a>
    </div>
</article>