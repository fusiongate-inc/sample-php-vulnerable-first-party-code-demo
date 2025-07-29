<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | In production, we want to minimize the exposure of sensitive information
 | to potential attackers. Error reporting should be disabled, and errors
 | should be logged instead of displayed.
 |
 | If you set 'display_errors' to '0', CI4's detailed error report will not show.
 */
error_reporting(0);
ini_set('display_errors', '0');

/*
 |--------------------------------------------------------------------------
 | DEBUG BACKTRACES
 |--------------------------------------------------------------------------
 | In production, debug backtraces should be disabled to prevent potential
 | exposure of sensitive information.
 */
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', false);

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode should be disabled in production to prevent potential
 | performance issues and exposure of sensitive information.
 */
defined('CI_DEBUG') || define('CI_DEBUG', false);