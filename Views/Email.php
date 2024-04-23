<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <?php if($parameters["hash"]) { ?>
        <div class="p-5">
            <a class="w-100 btn btn-primary" href="<?= $parameters["getPath"]("/email/" . $parameters["hash"]); ?>"> <?= $parameters["getText"]("email-web"); ?> </a>
        </div>
    <?php } ?>
    <h1 class="p-5 fw-bold"> <?= $parameters["title"]; ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["content"]; ?> </p>
    <?php if(!$parameters["hash"]) { ?>
        <p class="p-5 text-end"> <?= $parameters["getText"]("email-sent") . " "  . $parameters["email"] . ", " . $parameters["getText"]("email-on") . " "  . $parameters["date"] . " " . $parameters["getText"]("email-at") . " "  . $parameters["time"]; ?> </p>
        <div class="p-5">
            <a class="w-100 btn rounded-pill button-classic" href="<?= $parameters["getPath"]("/"); ?>"> <?= $parameters["getText"]("email-button"); ?> </a>
        </div>
    <?php } ?>
</article>