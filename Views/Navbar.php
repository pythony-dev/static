<nav class="fixed-top justify-content-around px-5 navbar navbar-expand-md navbar-light bg-light shadow border rounded-bottom">
    <a class="d-flex navbar-brand" href="<?= $parameters["getPath"]("/"); ?>">
        <img class="pe-4 icon" src="<?= $parameters["getPath"]("/Public/Images/Main/Icon.png"); ?>" alt="<?= $parameters["getText"]("navbar-title"); ?>"/>
        <p class="h1 my-auto ps-4"> <?= $parameters["getText"]("navbar-title"); ?> </p>
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
        <span class="navbar-toggler-icon"> </span>
    </button>
    <div id="navbar-collapse" class="py-4 navbar-collapse collapse">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link<?= $parameters["getRoute"]() != "Home" ? "" : " active"; ?>" href="<?= $parameters["getPath"]("/"); ?>"> <?= $parameters["getText"]("navbar-home"); ?> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= !in_array($parameters["getRoute"](), array("News", "Article")) ? "" : " active"; ?>" href="<?= $parameters["getPath"]("/news"); ?>"> <?= $parameters["getText"]("navbar-news"); ?> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= $parameters["getRoute"]() != "Contact" ? "" : " active"; ?>" href="<?= $parameters["getPath"]("/contact"); ?>"> <?= $parameters["getText"]("navbar-contact"); ?> </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href data-bs-toggle="dropdown"> <?= $parameters["getText"]("navbar-language"); ?> </a>
                <ul class="dropdown-menu">
                    <?php foreach($parameters["getAllLanguages"]() as $language) { ?>
                        <li>
                            <a class="dropdown-item<?= $parameters["getLanguage"]() != $language ? "" : " active"; ?> language" href language="<?= $language; ?>"> <?= ucfirst($language); ?> </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>