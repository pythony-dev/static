
<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <title> <?= htmlspecialchars($title) . " - " . $parameters["getText"]("project-name"); ?> </title>
        <link rel="icon" href="<?= $parameters["getPath"]("/Public/Images/Index/Icon.png"); ?>"/>
        <?php foreach($styles as $style) { ?>
            <link rel="stylesheet" href="<?= $parameters["getPath"]($style); ?>"/>
        <?php } foreach($scripts as $script) { ?>
            <script src="<?= $parameters["getPath"]($script); ?>" defer> </script>
        <?php } ?>
    </head>
    <body class="container p-0 text-center" style="background-image : url('<?= $parameters["getPath"]("/Public/Images/Index/Background.png"); ?>')">
        <?= \Static\Components\Navbar::create(); ?>
        <section class="bg-white shadow border rounded-bottom section">
            <?= $body . \Static\Components\Footer::create(); ?>
        </section>
    </body>
</html>
