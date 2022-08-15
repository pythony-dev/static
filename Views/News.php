<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("news-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("news-content"); ?> </p>
    <?php
        foreach($parameters["articles"] as $id => $article) echo \Static\Components\Article::create($id, $article["image"], $article["title"], $article["overview"], $parameters["getText"]("news-button"), $article["link"]);

        if(count($parameters["articles"]) == 0) echo "<p class=\"p-5\"> " . $parameters["getText"]("news-empty") . " </p>";
    ?>
    <div class="p-5"> <?= Static\Components\Pagination::create($parameters["page"], $parameters["limit"], $parameters["getPath"]("/news")); ?> </div>
</article>