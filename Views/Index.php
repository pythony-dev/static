
<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title> <?= htmlspecialchars($title) . " - " . $parameters["getSettings"]("project-name"); ?> </title>
        <link rel="icon" href="<?= $parameters["getPath"]("/Public/Images/Index/Icon.png"); ?>"/>
        <?php foreach($styles as $style) { ?>
            <link rel="stylesheet" href="<?= $style; ?>"/>
        <?php } foreach($scripts as $script) { ?>
            <script src="<?= $script; ?>" defer> </script>
        <?php } ?>
    </head>
    <body class="container text-center" style="background-image : url('<?= $parameters["getPath"]("/Public/Images/Index/Background.png"); ?>')">
        <?= \Static\Components\Navbar::create(); ?>
        <section class="bg-white shadow border section"> <?= $body; ?> </section>
        <?php
            echo \Static\Components\Footer::create();

            if(is_array($parameters["modals"])) {
                foreach($parameters["modals"] as $modal) {
                    if(file_exists("Views/Modals/" . ucfirst($modal) . ".php")) require_once("Views/Modals/" . ucfirst($modal) . ".php");
                }
            }
        ?>
        <div class="d-none">
            <?php if(is_array($parameters["alerts"])) foreach($parameters["alerts"] as $alert) { ?>
                <input id="<?= htmlspecialchars($alert); ?>" value="<?= $parameters["getText"](htmlspecialchars($alert)); ?>"/>
            <?php } ?>
        </div>
    </body>
</html>
