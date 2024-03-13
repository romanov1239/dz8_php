{% if not user_authorized %}
<p><a href="/user/auth/">Вход в систему</a></p>
{% else %}
<p>Добро пожаловать на сайт, {{ user_name }}!</p>
<form method="POST">
    <input type="submit" name="logout" value="Выход">
</form>
{% endif %}
