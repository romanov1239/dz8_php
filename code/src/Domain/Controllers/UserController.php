<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Domain\Models\User;

class UserController extends AbstractController
{
    protected array $actionsPermissions = [
        'actionHash' => ['admin'],
        'actionAuth' => ['admin'],
        'actionSave' => ['admin'],
        'actionUpdate' => ['admin'],
        'actionLogin' => ['admin'],
        'actionDelete' => ['admin'],
        'actionIndex' => ['admin'],
        'actionLogout' => ['admin']
    ];

    public function actionIndex ()
    {
        $users = User ::getAllUsersFromStorage ();
        $render = new Render();
        if (!$users) {
            return $render -> renderPage (
                'user-empty.tpl',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => 'Список пуст или не найден'
                ]
            );
        } else {
            return $render -> renderPage (
                'user-index.tpl',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]
            );
        }
    }

    public function actionUpdate (): string
    {
        $render = new Render();

        if (!empty($_POST['id']) && !empty($_POST['name'])) {
            $userId = $_POST['id'];
            $newName = $_POST['name'];

            $user = User ::getUserById ($userId);
            if ($user) {
                $user -> setUserName ($newName);
                $user -> saveToStorage ();

                return $render -> renderPage (
                    'user-updated.tpl',
                    [
                        'title' => 'Пользователь обновлен',
                        'message' => 'Имя пользователя успешно изменено на ' . $newName
                    ]
                );
            } else {
                return $render -> renderPage (
                    'user-not-found.tpl',
                    [
                        'title' => 'Ошибка',
                        'message' => 'Пользователь с указанным ID не найден'
                    ]
                );
            }
        }

        return $render -> renderPage ('user-update.tpl', ['title' => 'Форма изменения пользователя']);
    }

    public function actionDelete (): string
    {
        $render = new Render();

        if (!empty($_POST['id'])) {
            $userId = $_POST['id'];

            $user = User ::getUserById ($userId);
            if ($user) {
                $user -> deleteFromStorage ();

                return $render -> renderPage (
                    'user-deleted.tpl',
                    [
                        'title' => 'Пользователь удален',
                        'message' => 'Пользователь успешно удален'
                    ]
                );
            } else {
                return $render -> renderPage (
                    'user-not-found.tpl',
                    [
                        'title' => 'Ошибка',
                        'message' => 'Пользователь с указанным ID не найден'
                    ]
                );
            }
        }

        return $render -> renderPage ('user-delete.tpl', ['title' => 'Форма удаления пользователя']);
    }

    public function actionEdit (): string
    {
        $render = new Render();
        return $render -> renderPageWithForm ('user-form.tpl',
            [
                'title' => 'Форма создания пользователя'
            ]);
    }

    public function actionSave (): string
    {
        $render = new Render();


        if (!empty($_POST)) {

            if (User ::validateRequestData ()) {
                $user = new User();
                $user -> setParamsFromRequestData ();
                $user -> saveToStorage ();

                return $render -> renderPage (
                    'user-created.tpl',
                    [
                        'title' => 'Пользователь создан',
                        'message' => "Создан пользователь " . $user -> getUserName () . " " . $user -> getUserLastName ()
                    ]
                );
            } else {

                return $render -> renderPage ('error.tpl', ['title' => 'Ошибка', 'message' => 'Ошибка при валидации данных.']);
            }
        }


        return $render -> renderPage ('user-addBD.tpl', ['title' => 'Форма добавления пользователя']);
    }

    public function actionHash (): string
    {
        return Auth ::getPasswordHash ($_GET['pass_string']);
    }

    public function actionAuth (): string
    {

        $render = new Render();
        return $render -> renderPageWithForm (
            'user-auth.tpl', [
                'title' => 'Форма логина'
            ]
        );
    }

    public function actionLogin (): string
    {
        $result = false;
        $render = new Render();

        if (isset($_POST['login']) && isset($_POST['password'])) {
            $result = Application ::$auth -> proceedAuth ($_POST['login'], $_POST['password']);

            if (!$result) {
                return $render -> renderPageWithForm (
                    'user-auth.tpl',
                    [
                        'title' => 'Форма логина',
                        'auth_success' => false,
                        'auth_error' => 'Неверные логин или пароль',
                        'csrf_token' => $_SESSION['csrf_token']
                    ]);
            } else {
                header ('Location: /');
                return "";
            }
        }

        return $render -> renderPage (
            'page-index.tpl',
            [
                'user_authorized' => isset($_SESSION['user_authorized']) ? $_SESSION['user_authorized'] : false
            ]
        );
    }

    public function actionLogout (): string
    {
        $auth = new Auth();
        $auth -> logout ();
        header ('Location: /user/auth/');
        exit();
    }
}