
<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <title> <?= htmlspecialchars($title); ?> - Static </title>
        <link rel="icon" href="<?= $parameters["getPath"]("/Public/Images/Main/Icon.png"); ?>"/>
        <?php foreach($styles as $style) { ?>
            <link rel="stylesheet" href="<?= $parameters["getPath"]($style); ?>"/>
        <?php } foreach($scripts as $script) { ?>
            <script src="<?= $parameters["getPath"]($script); ?>" defer> </script>
        <?php } ?>
    </head>
    <body class="container text-center" style="background-image : url('<?= $parameters["getPath"]("/Public/Images/Main/Background.png"); ?>')">
        <?php require_once("Views/Navbar.php"); ?>
        <section class="bg-white shadow border rounded-bottom section">
            <?php
                echo $body;

                require_once("Views/Footer.php");
            ?>
        </section>
    </body>
</html>
