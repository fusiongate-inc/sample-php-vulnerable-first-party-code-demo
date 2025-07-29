<?php
use CodeIgniter\HTTP\Header;
use CodeIgniter\CodeIgniter;

$errorId = uniqid('error', true);
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>

    <script>
        <?= file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.js') ?>
    </script>
</head>
<body onload="init()">

    <!-- Header -->
    <div class="header">
        <div class="environment">
            Displayed at <?= htmlspecialchars(date('H:i:sa'), ENT_QUOTES, 'UTF-8') ?> &mdash;
            PHP: <?= htmlspecialchars(PHP_VERSION, ENT_QUOTES, 'UTF-8') ?>  &mdash;
            CodeIgniter: <?= htmlspecialchars(CodeIgniter::CI_VERSION, ENT_QUOTES, 'UTF-8') ?> --
            Environment: <?= htmlspecialchars(ENVIRONMENT, ENT_QUOTES, 'UTF-8') ?>
        </div>
        <div class="container">
            <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'), ($exception->getCode() ? ' #' . htmlspecialchars($exception->getCode(), ENT_QUOTES, 'UTF-8') : '') ?></h1>
            <p>
                <?= nl2br(htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8')) ?>
                <a href="https://www.duckduckgo.com/?q=<?= urlencode($title . ' ' . preg_replace('#\'.*\'|".*"#Us', '', htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8'))) ?>"
                   rel="noreferrer" target="_blank">search &rarr;</a>
            </p>
        </div>
    </div>

    <!-- Source -->
    <div class="container">
        <p><b><?= htmlspecialchars(clean_path($file), ENT_QUOTES, 'UTF-8') ?></b> at line <b><?= htmlspecialchars($line, ENT_QUOTES, 'UTF-8') ?></b></p>

        <?php if (is_file($file)) : ?>
            <div class="source">
                <?= highlightFile($file, $line, 15); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="container">
        <?php
        $last = $exception;

        while ($prevException = $last->getPrevious()) {
            $last = $prevException;
            ?>

    <pre>
    Caused by:
    <?= htmlspecialchars($prevException::class, ENT_QUOTES, 'UTF-8'), ($prevException->getCode() ? ' #' . htmlspecialchars($prevException->getCode(), ENT_QUOTES, 'UTF-8') : '') ?>

    <?= nl2br(htmlspecialchars($prevException->getMessage(), ENT_QUOTES, 'UTF-8')) ?>
    <a href="https://www.duckduckgo.com/?q=<?= urlencode(htmlspecialchars($prevException::class, ENT_QUOTES, 'UTF-8') . ' ' . preg_replace('#\'.*\'|".*"#Us', '', htmlspecialchars($prevException->getMessage(), ENT_QUOTES, 'UTF-8'))) ?>"
       rel="noreferrer" target="_blank">search &rarr;</a>
    <?= htmlspecialchars(clean_path($prevException->getFile()) . ':' . $prevException->getLine(), ENT_QUOTES, 'UTF-8') ?>
    </pre>

        <?php
        }
        ?>
    </div>

    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE) : ?>
    <div class="container">

        <ul class="tabs" id="tabs">
            <li><a href="#backtrace">Backtrace</a></li>
            <li><a href="#server">Server</a></li>
            <li><a href="#request">Request</a></li>
            <li><a href="#response">Response</a></li>
            <li><a href="#files">Files</a></li>
            <li><a href="#memory">Memory</a></li>
        </ul>

        <div class="tab-content">

            <!-- Backtrace -->
            <div class="content" id="backtrace">

                <ol class="trace">
                <?php foreach ($trace as $index => $row) : ?>

                    <li>
                        <p>
                            <!-- Trace info -->
                            <?php if (isset($row['file']) && is_file($row['file'])) : ?>
                                <?php
                                if (isset($row['function']) && in_array($row['function'], ['include', 'include_once', 'require', 'require_once'], true)) {
                                    echo htmlspecialchars($row['function'] . ' ' . clean_path($row['file']), ENT_QUOTES, 'UTF-8');
                                } else {
                                    echo htmlspecialchars(clean_path($row['file']) . ' : ' . $row['line'], ENT_QUOTES, 'UTF-8');
                                }
                                ?>
                            <?php else: ?>
                                {PHP internal code}
                            <?php endif; ?>

                            <!-- Class/Method -->
                            <?php if (isset($row['class'])) : ?>
                                &nbsp;&nbsp;&mdash;&nbsp;&nbsp;<?= htmlspecialchars($row['class'] . $row['type'] . $row['function'], ENT_QUOTES, 'UTF-8') ?>
                                <?php if (! empty($row['args'])) : ?>
                                    <?php $argsId = $errorId . 'args' . $index ?>
                                    ( <a href="#" onclick="return toggle('<?= htmlspecialchars($argsId, ENT_QUOTES, 'UTF-8') ?>');">arguments</a> )
                                    <div class="args" id="<?= htmlspecialchars($argsId, ENT_QUOTES, 'UTF-8') ?>">
                                        <table cellspacing="0">

                                        <?php
                                        $params = null;
                                        // Reflection by name is not available for closure function
                                        if (! str_ends_with($row['function'], '}')) {
                                            $mirror = isset($row['class']) ? new ReflectionMethod($row['class'], $row['function']) : new ReflectionFunction($row['function']);
                                            $params = $mirror->getParameters();
                                        }

                                        foreach ($row['args'] as $key => $value) : ?>
                                            <tr>
                                                <td><code><?= htmlspecialchars(isset($params[$key]) ? '$' . $params[$key]->name : "#{$key}", ENT_QUOTES, 'UTF-8') ?></code></td>
                                                <td><pre><?= htmlspecialchars(print_r($value, true), ENT_QUOTES, 'UTF-8') ?></pre></td>
                                            </tr>
                                        <?php endforeach ?>

                                        </table>
                                    </div>
                                <?php else : ?>
                                    ()
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (! isset($row['class']) && isset($row['function'])) : ?>
                                &nbsp;&nbsp;&mdash;&nbsp;&nbsp;    <?= htmlspecialchars($row['function'], ENT_QUOTES, 'UTF-8') ?>()
                            <?php endif; ?>
                        </p>

                        <!-- Source? -->
                        <?php if (isset($row['file']) && is_file($row['file']) && isset($row['class'])) : ?>
                            <div class="source">
                                <?= highlightFile($row['file'], $row['line']) ?>
                            </div>
                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>
                </ol>

            </div>

            <!-- Server -->
            <div class="content" id="server">
                <?php foreach (['_SERVER', '_SESSION'] as $var) : ?>
                    <?php
                    if (empty($GLOBALS[$var]) || ! is_array($GLOBALS[$var])) {
                        continue;
                    } ?>

                    <h3>$<?= htmlspecialchars($var, ENT_QUOTES, 'UTF-8') ?></h3>

                    <table>
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($GLOBALS[$var] as $key => $value) : ?>
                            <tr>
                                <td><?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php if (is_string($value)) : ?>
                                        <?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>
                                    <?php else: ?>
                                        <pre><?= htmlspecialchars(print_r($value, true), ENT_QUOTES, 'UTF-8') ?></pre>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php endforeach ?>

                <!-- Constants -->
                <?php $constants = get_defined_constants(true); ?>
                <?php if (! empty($constants['user'])) : ?>
                    <h3>Constants</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($constants['user'] as $key => $value) : ?>
                            <tr>
                                <td><?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php if (is_string($value)) : ?>
                                        <?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>
                                    <?php else: ?>
                                        <pre><?= htmlspecialchars(print_r($value, true), ENT_QUOTES, 'UTF-8') ?></pre>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <!-- Request -->
            <div class="content" id="request">
                <?php $request = service('request'); ?>

                <table>
                    <tbody>
                        <tr>
                            <td style="width: 10em">Path</td>
                            <td><?= htmlspecialchars($request->getUri(), ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <td>HTTP Method</td>
                            <td><?= htmlspecialchars($request->getMethod(), ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <td>IP Address</td>
                            <td><?= htmlspecialchars($request->getIPAddress(), ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10em">Is AJAX Request?</td>
                            <td><?= $request->isAJAX() ? 'yes' : 'no' ?></td>
                        </tr>
                        <tr>
                            <td>Is CLI Request?</td>
                            <td><?= $request->isCLI() ? 'yes' : 'no' ?></td>
                        </tr>
                        <tr>
                            <td>Is Secure Request?</td>
                            <td><?= $request->isSecure() ? 'yes' : 'no' ?></td>
                        </tr>
                        <tr>
                            <td>User Agent</td>
                            <td><?= htmlspecialchars($request->getUserAgent()->getAgentString(), ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>

                    </tbody>
                </table>


                <?php $empty = true; ?>
                <?php foreach (['_GET', '_POST', '_COOKIE'] as $var) : ?>
                    <?php
                    if (empty($GLOBALS[$var]) || ! is_array($GLOBALS[$var])) {
                        continue;
                    } ?>

                    <?php $empty = false; ?>

                    <h3>$<?= htmlspecialchars($var, ENT_QUOTES, 'UTF-8') ?></h3>

                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($GLOBALS[$var] as $key => $value) : ?>
                            <tr>
                                <td><?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php if (is_string($value)) : ?>
                                        <?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>
                                    <?php else: ?>
                                        <pre><?= htmlspecialchars(print_r($value, true), ENT_QUOTES, 'UTF-8') ?></pre>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php endforeach ?>

                <?php if ($empty) : ?>

                    <div class="alert">
                        No $_GET, $_POST, or $_COOKIE Information to show.
                    </div>

                <?php endif; ?>

                <?php $headers = $request->headers(); ?>
                <?php if (! empty($headers)) : ?>

                    <h3>Headers</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>Header</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($headers as $name => $value) : ?>
                            <tr>
                                <td><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                <?php
                                if ($value instanceof Header) {
                                    echo htmlspecialchars($value->getValueLine(), ENT_QUOTES, 'UTF-8');
                                } else {
                                    foreach ($value as $i => $header) {
                                        echo ' ('. ($i+1) . ') ' . htmlspecialchars($header->getValueLine(), ENT_QUOTES, 'UTF-8');
                                    }
                                }
                                ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php endif; ?>
            </div>

            <!-- Response -->
            <?php