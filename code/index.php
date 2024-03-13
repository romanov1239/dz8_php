<?php

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;

require_once 'vendor/autoload.php';


try {
    $app = new Application();
    echo $app -> run ();
} catch (\Exception $e) {
    echo Render::renderExceptionPage ($e);
}







