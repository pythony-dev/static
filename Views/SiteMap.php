<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("siteMap-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("siteMap-content"); ?> </p>
    <ul class="p-5 text-start list-unstyled">
        <?php foreach($parameters["links"] as $name => $link) { ?>
            <li>
                <?php if(!is_array($link)) { ?>
                    <a<?= $link != "/welcome" ? null : " id=\"siteMap-welcome\""; ?> class="text-decoration-none" href="<?= $parameters["getPath"]($link); ?>"> <?= $name; ?> </a>
                <?php } else { ?>
                    <ul class="ps-5 list-unstyled">
                        <?php foreach($link as $subname => $sublink) { ?>
                            <li>
                                <?php if(!is_array($sublink)) { ?>
                                    <a class="text-decoration-none" href="<?= $parameters["getPath"]($sublink); ?>"> <?= $subname; ?> </a>
                                <?php } else { ?>
                                    <ul class="ps-5 list-unstyled">
                                        <?php foreach($sublink as $subsubname => $subsublink) { ?>
                                            <li>
                                                <a class="text-decoration-none" href="<?= $parameters["getPath"]($subsublink); ?>"> <?= $subsubname; ?> </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</article>