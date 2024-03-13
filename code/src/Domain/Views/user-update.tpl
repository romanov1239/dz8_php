{% block content %}
<h1>Форма изменения пользователя</h1>

<form action="" method="post" id="user-update-form">
    <label for="id">ID пользователя
        <input type="text" name="id" id="id" required>
    </label>

    <label for="name">Новое имя пользователя
        <input type="text" name="name" id="name" required>
    </label>

    <input type="submit" value="Изменить">
</form>
{% endblock %}
