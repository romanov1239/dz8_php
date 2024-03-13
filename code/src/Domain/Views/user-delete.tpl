{% block content %}
<h1>Форма удаления пользователя</h1>

<form action="delete/" method="post" id="user-update-form">
    <label for="id">ID пользователя
        <input type="text" name="id" id="id" required>
    </label>

    <input type="submit" value="Удалить">
</form>
{% endblock %}
