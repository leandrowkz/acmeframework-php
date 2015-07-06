<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Header
echo "\n\t" . lang('Database Error') . ":\n";

// Messages
if (is_array($message)) {
    foreach($message as $msg)
        if($msg != '')
            echo "\n\t- " . $msg;
} else {
    echo "\n\t- " . $message;
}

// Ending
echo "\n\n";
