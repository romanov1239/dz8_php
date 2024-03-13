<?php

namespace Geekbrains\Application1\Domain\Controllers;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\SiteInfo;

class InfoController
{
    public function actionIndex (): string
    {
        $siteInfo=new SiteInfo();
        $info=$siteInfo->getInfo ();
        $render=new Render();
        return $render->renderPage ('site-info.tpl',$info);
    }
}