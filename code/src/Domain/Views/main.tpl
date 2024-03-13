<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ title }}</title>
    <link rel="stylesheet" href="../../../style.css">
</head>
<body>


<header>
    <div class="header-content">
        {% if user_authorized %}
        <p class="welcome-message">Добро пожаловать на сайт, {{ user_login }}!</p>
        <form method="POST" action="/user/logout/" class="logout-form">
            <input type="submit" value="Выход">
        </form>
        {% else %}
        <p><a href="/user/auth/">Вход в систему</a></p>
        {% endif %}
    </div>

    <p>
        {% set now = date('now', 'Europe/Moscow') %}
        Текущее время: {{ now.format('H:i:s') }}
    </p>

    <nav>
        <a href="/">Главная</a>
        <a href="/user">Пользователи</a>
        <a href="/about">О нас</a>

        <a href="/user/save">Добавить в БД</a>
        <a href="/user/update">Изменить пользователя в БД</a>
        <a href="/user/delete">Удалить пользователя в БД</a>
    </nav>
</header>


<main>
    {% if content_template_name == 'error.tpl' %}
    {% include content_template_name with {'title': title, 'message': message, 'code': code, 'file': file, 'line': line} %}
    {% else %}
    {% include content_template_name %}
    {% endif %}
</main>

{% include 'site-footer.tpl' %}

</body>
</html>
