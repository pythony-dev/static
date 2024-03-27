
<!DOCTYPE HTML>

<html lang="<?= substr(\Static\Languages\Translate::getLanguage(), 0, 2); ?>" data-bs-theme="<?= \Static\Kernel::isLight() ? "light" : "dark"; ?>">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title> <?= htmlspecialchars($title) . " - " . $parameters["getSettings"]("project-name"); ?> </title>
        <link rel="manifest" href="<?= $parameters["getPath"]("/manifest"); ?>"/>
        <?php foreach($styles as $style) { ?>
            <link rel="stylesheet" href="<?= $parameters["getPath"]($style); ?>"/>
        <?php } ?>
        <link rel="icon" href="<?= $parameters["getPath"]("/Public/Images/Index/Icon.png"); ?>"/>
        <style> <?php require("Public/Styles/" . (\Static\Kernel::isLight() ? "Light" : "Dark") . ".php"); ?> </style>
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
                    foreach($parameters["alerts"] as $alert) {
                        $state = "success";
                        $color = "success";

                        if(str_contains($parameters["getText"]($alert), "!")) {
                            $state = "error";
                            $color = "danger";
                        } else if(str_contains($parameters["getText"]($alert), "?")) {
                            $state = "confirm";
                            $color = "warning";
                        }
                    ?>

                    <div id="<?= str_replace("-alert", "", $alert); ?>-alert" class="modal fade p-5">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="px-4 py-5 mb-0 alert">
                                    <h3 class="p-4"> <?= $parameters["getText"]("index-alert-" . $state); ?> </h3>
                                    <p class="p-4"> <?= $parameters["getText"]($alert); ?> </p>
                                    <div class="p-4">
                                        <?php if($color != "warning") { ?>
                                            <button class="w-100 btn rounded-pill button-outline" data-bs-dismiss="modal"> <?= $parameters["getText"]("index-alert-close"); ?> </button>
                                        <?php } else { ?>
                                            <button class="w-100 btn rounded-pill button-normal confirm"> <?= $parameters["getText"]("index-alert-ok"); ?> </button>
                                            <button class="w-100 mt-4 btn rounded-pill button-outline" data-bs-dismiss="modal"> <?= $parameters["getText"]("index-alert-cancel"); ?> </button>
                                        <?php } ?>
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
