<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\Phone;

class AboutController
{
    public function actionIndex ()
    {
        $phone = (new Phone()) -> getPhone ();
        $render = new Render();

        try {
            return $render -> renderPage ('about.tpl', [
                'phone' => $phone
            ]);
        } catch (\Exception $e) {
            return $e -> getMessage ();
        }
    }
}