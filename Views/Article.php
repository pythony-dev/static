<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["title"]; ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["overview"]; ?> </p>
    <div class="p-5">
        <img class="img-fluid shadow border rounded" src="<?= $parameters["image"] ?>" alt="<?= $parameters["title"]; ?>"/>
    </div>
    <p class="p-5 text-justify"> <?= $parameters["content"]; ?> </p>
    <p class="p-5 text-end"> <?= $parameters["getText"]("article-published") . $parameters["published"]; ?> </p>
    <?php if(count($parameters["networks"])) { ?>
        <p class="p-5 h3"> <?= $parameters["getText"]("article-share"); ?> </p>
        <div class="d-flex justify-content-between p-5">
            <?php foreach(\Static\Kernel::getNetworks() as $network) if(array_key_exists(strtolower($network), $parameters["networks"])) { ?>
                <a href="<?= \Static\Kernel::getValue($parameters, array("networks", strtolower($network))); ?>" target="_blank">
                    <img class="img-fluid shadow border rounded-circle networks" src="<?= $parameters["getPath"]("/Public/Images/Networks/" . $network . ".png"); ?>" alt="<?= $network; ?>"/>
                </a>
            <?php } ?>
        </div>
    <?php } if(count($parameters["random"])) { ?>
        <div class="p-5">
            <div class="line"> </div>
        </div>
    <?php } foreach($parameters["random"] as $id => $article) echo \Static\Components\Article::create($id, $article["image"], $article["title"], $article["overview"], $parameters["getText"]("article-button"), $parameters["getPath"]("/article/" . $article["link"])); ?>
</article>