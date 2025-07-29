<?php

use CodeIgniter\CLI\CLI;

// The main Exception
CLI::write('[' . $exception::class . ']', 'light_gray', 'red');
CLI::write($message);
$file = $exception->getFile();
$line = $exception->getLine();
CLI::write('at ' . CLI::color(clean_path($file) . ':' . $line, 'green'));
CLI::newLine();

$last = $exception;
$backtraces = $last->getTrace();

while ($prevException = $last->getPrevious()) {
    $last = $prevException;
    $backtraces = array_merge($backtraces, $prevException->getTrace());

    CLI::write('  Caused by:');
    CLI::write('  [' . $prevException::class . ']', 'red');
    CLI::write('  ' . $prevException->getMessage());
    $file = $prevException->getFile();
    $line = $prevException->getLine();
    CLI::write('  at ' . CLI::color(clean_path($file) . ':' . $line, 'green'));
    CLI::newLine();
}

// The backtrace
if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE) {
    if ($backtraces) {
        CLI::write('Backtrace:', 'green');
    }

    $cachedCleanPath = [];

    foreach ($backtraces as $i => $error) {
        $padFile  = '    '; // 4 spaces
        $padClass = '       '; // 7 spaces
        $c        = str_pad($i + 1, 3, ' ', STR_PAD_LEFT);

        if (isset($error['file'])) {
            $filepath = $error['file'] . ':' . $error['line'];
            $cleanPath = $cachedCleanPath[$filepath] ?? ($cachedCleanPath[$filepath] = clean_path($filepath));
            CLI::write($c . $padFile . CLI::color($cleanPath, 'yellow'));
        } else {
            CLI::write($c . $padFile . CLI::color('[internal function]', 'yellow'));
        }

        $function = '';

        if (isset($error['class'])) {
            $type = ($error['type'] === '->') ? '()' . $error['type'] : $error['type'];
            $function .= $padClass . $error['class'] . $type . $error['function'];
        } elseif (! isset($error['class']) && isset($error['function'])) {
            $function .= $padClass . $error['function'];
        }

        $args = implode(', ', array_map(static function ($value) {
            if (is_object($value)) {
                return 'Object(' . $value::class . ')';
            } elseif (is_array($value)) {
                return $value !== [] ? '[...]' : '[]';
            } elseif ($value === null) {
                return 'null';
            } else {
                return var_export($value, true);
            }
        }, array_values($error['args'] ?? [])));

        $function .= '(' . $args . ')';

        CLI::write($function);
        CLI::newLine();
    }
}