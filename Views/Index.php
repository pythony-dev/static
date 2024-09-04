
<!DOCTYPE HTML>

<html lang="<?= substr(\Static\Languages\Translate::getLanguage(), 0, 2); ?>" data-bs-theme="<?= \Static\Kernel::isLight() ? "light" : "dark"; ?>" link="<?= $parameters["getSettings"]("link"); ?>"<?= !is_array($parameters["tests"]) ? null : " tests=\"" . str_replace("\"", "'", json_encode($parameters["tests"])) . "\""; ?>>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title> <?= htmlspecialchars($title) . " - " . $parameters["getSettings"]("name"); ?> </title>
        <link rel="manifest" href="<?= $parameters["getPath"]("/manifest"); ?>" crossorigin="use-credentials"/>
        <?php foreach($styles as $style) { ?>
            <link rel="stylesheet" href="<?= $parameters["getPath"]($style); ?>"/>
        <?php } ?>
        <link rel="icon" href="<?= $parameters["getPath"]("/Public/Images/Index/Icon.png"); ?>"/>
        <style> <?php require("Public/Styles/Index.php"); ?> </style>
        <?php foreach($scripts as $script) { ?>
            <script src="<?= $parameters["getPath"]($script); ?>" defer> </script>
        <?php } ?>
    </head>
    <body class="container text-center">
        <?php if(!$parameters["hash"]) echo \Static\Components\Navbar::create(); ?>
        <section class="bg-<?= \Static\Kernel::isLight() ? "light" : "dark"; ?> shadow border<?= !$parameters["hash"] ? " section" : null; ?>"> <?= $body; ?> </section>
        <?= \Static\Components\Footer::create(); ?>
        <div>
            <?php
                if(!$parameters["hash"] && is_array($parameters["modals"])) {
                    foreach($parameters["modals"] as $modal) {
                        if(file_exists("Views/Modals/" . ucfirst($modal) . ".php")) require_once("Views/Modals/" . ucfirst($modal) . ".php");
                    }
                }

                if(!$parameters["hash"] && is_array($parameters["alerts"])) {
                    foreach($parameters["alerts"] as $alert) { ?>

                    <div id="alert-<?= str_replace("-alert", "", $alert); ?>" class="modal fade p-5">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="row p-4 mx-0 mb-0 alert alert-<?= str_contains($parameters["getText"]($alert), "!") ? "danger" : (str_contains($parameters["getText"]($alert), "?") ? "warning" : "success"); ?>">
                                    <div class="col-12 col-md-10 px-0">
                                        <p class="mb-0"> <?= $parameters["getText"]($alert); ?> </p>
                                        <?php if(str_contains($parameters["getText"]($alert), "?")) { ?>
                                            <button class="w-50 mt-4 btn rounded-pill button-outline alert-yes"> <?= $parameters["getText"]("index-alert-yes"); ?> </button>
                                        <?php } ?>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center col-12 col-md-2 px-0 pt-4 pt-md-0">
                                        <button id="alert-<?= str_replace("-alert", "", $alert); ?>-close" class="btn-close alert-close" alert="<?= str_replace("-alert", "", $alert); ?>"> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php }
                }
            ?>
        </div>
    </body>
</html>
