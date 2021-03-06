
<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <title> <?= htmlspecialchars($title) . " - " . $parameters["getSettings"]("project-name"); ?> </title>
        <link rel="icon" href="<?= $parameters["getPath"]("/Public/Images/Index/Icon.png"); ?>"/>
        <?php foreach($styles as $style) { ?>
            <link rel="stylesheet" href="<?= $style; ?>"/>
        <?php } foreach($scripts as $script) { ?>
            <script src="<?= $script; ?>" defer> </script>
        <?php } ?>
    </head>
    <body class="container p-0 text-center" style="background-image : url('<?= $parameters["getPath"]("/Public/Images/Index/Background.png"); ?>')">
        <?= \Static\Components\Navbar::create($parameters["userID"]); ?>
        <section class="bg-white shadow border section">
            <?= $body; ?>
        </section>
        <?= \Static\Components\Footer::create(); ?>
        <div>
            <?php if(is_array($parameters["alerts"])) foreach($parameters["alerts"] as $alert) { ?>
                <input id="<?= $alert; ?>" class="d-none" value="<?= $parameters["getText"]($alert); ?>"/>
            <?php } ?>
        </div>
    </body>
</html>
