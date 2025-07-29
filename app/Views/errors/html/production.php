<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= lang('Errors.whoops') ?></title>

    <style>
        <?php
        $cssFilePath = __DIR__ . DIRECTORY_SEPARATOR . 'debug.css';
        if (file_exists($cssFilePath)) {
            $cssContent = file_get_contents($cssFilePath);
            $minifiedCssContent = preg_replace('#[\r\n\t ]+#', ' ', $cssContent);
            echo $minifiedCssContent;
        } else {
            // Handle the case when the CSS file is missing
            echo '/* CSS file not found */';
        }
        ?>
    </style>
</head>
<body>

    <div class="container text-center">

        <h1 class="headline"><?= lang('Errors.whoops') ?></h1>

        <p class="lead"><?= lang('Errors.weHitASnag') ?></p>

    </div>

</body>
</html>