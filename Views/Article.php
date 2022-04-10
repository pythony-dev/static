<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["title"]; ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["overview"]; ?> </p>
    <div class="p-5">
        <img class="img-fluid shadow border rounded" src="<?= $parameters["image"] ?>" alt="<?= $parameters["title"]; ?>"/>
    </div>
    <p class="p-5 text-justify"> <?= $parameters["content"]; ?> </p>
    <p class="p-5 text-end"> <?= $parameters["getText"]("article-published") . $parameters["published"]; ?> </p>
    <?php foreach($parameters["random"] as $id => $article) { ?>
        <div class="row mx-0 px-5<?= $id % 2 ? " flex-row-reverse" : null; ?>">
            <?php if($id != 0) { ?>
                <div class="d-md-none mx-auto my-5 line"> </div>
            <?php } ?>
            <div class="col-12 col-md-6 my-auto py-4">
                <img class="img-fluid shadow border rounded" src="<?= $article["image"]; ?>" alt="<?= $article["title"]; ?>"/>
            </div>
            <div class="col-12 col-md-6 my-auto px-md-4 py-4">
                <p class="h3 p-4"> <?= $article["title"]; ?> </p>
                <p class="p-4 text-justify"> <?= $article["overview"]; ?> </p>
                <a class="w-100 my-4 btn btn-outline-primary" href="<?= $article["button"]; ?>"> <?= $parameters["getText"]("article-action"); ?> </a>
            </div>
        </div>
    <?php } ?>
</article>