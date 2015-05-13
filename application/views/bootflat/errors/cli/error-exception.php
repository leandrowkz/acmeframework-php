<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Header
echo "\n\t" . lang('An uncaught Exception was encountered') . ":\n";

// Messages
echo "\n\t- " . lang('Type') . ': ' . get_class($exception);
echo "\n\t- " . lang('Message') . ': ' . $exception->getMessage();
echo "\n\t- " . lang('Filename') . ': ' . $exception->getFile();
echo "\n\t- " . lang('Line Number') . ': ' . $exception->getLine();

// Backtrace
if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE):

echo "\n\n\t" . lang('Backtrace') . ":\n";

foreach ($exception->getTrace() as $error):
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
