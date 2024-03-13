<?php

namespace Geekbrains\Application1\Application;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Render
{
    private string $viewFolder = '/src/Domain/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;

    public function __construct()
    {
        $this->loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
            //'cache'=>$_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    }

    public function renderPage(string $contentTemplateName = 'page-index.tpl', array $templateVariables = [])
    {

        $template = $this->environment->load('main.tpl');
        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['title'] = 'Наше первое приложение';

        $templateVariables['user_login']=$_SESSION['user_name'];
        if(isset($_SESSION['user_name'])){
            $templateVariables['user_authorized'] = true;
        }

        // Временный код
        /*
        ob_start();
        \xdebug_info();
        $xdebug = ob_get_clean();
        $templateVariables['xdebug'] = $xdebug;
         */
        //-------

        return $template->render($templateVariables);
    }
    public function renderPageWithForm(string $contentTemplateName = 'page-index.tpl', array $templateVariables = []) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $templateVariables['csrf_token'] = $_SESSION['csrf_token'];
        return $this->renderPage($contentTemplateName, $templateVariables);
    }

    public static function renderExceptionPage(\Throwable $e): string
    {
        $render = new Render();
        $mainTemplate = $render->environment->load('main.tpl');
        $template = $render->environment->load('error.tpl');

        $templateVariables = [
            'title' => 'Ошибка',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ];

        $templateVariables['content_template_name'] = 'error.tpl';

        return $mainTemplate->render($templateVariables);
    }
}
