<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Header
echo "\n\t" . lang('A PHP Error was encountered') . ":\n";

// Messages
echo "\n\t- " . lang('Severity') . ': ' . $severity;
echo "\n\t- " . lang('Message') . ': ' . $message;
echo "\n\t- " . lang('Filename') . ': ' . $filepath;
echo "\n\t- " . lang('Line Number') . ': ' . $line;

// Backtrace
if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE):

echo "\n\n\t" . lang('Backtrace') . ":\n";

foreach (debug_backtrace() as $error):
    if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0):
        echo "\n\t- " . lang('File') . ': ' . $error['file'];
        echo "\n\t- " . lang('Line') . ': ' . $error['line'];
        echo "\n\t- " . lang('Function') . ': ' . $error['function'];
        echo "\n";
    endif;
endforeach;

endif;

// Ending
echo "\n\n";
