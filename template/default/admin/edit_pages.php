<td class="content">

    <h1>
        Добавление страницы
    </h1>

    <form method="POST" action="/visitka/admin">
        <p><span>Заголовок страницы: &nbsp;
						</span><input class="txt-zag" type="text" name="title"></p>
        <p><span>Текст страницы:</span></p>
        <textarea rows="15" cols="60" name="text" id="text"></textarea>
        <br/><br/>
        <p><span>Позиция страницы: &nbsp;
						</span><input class="txt-num" type="text" name="position"></p>
        <input type="image" src="images/save_btn.jpg" name="add">

    </form>

</td>
<td class="rightbar-adm">
    <h1>
        Список страниц
    </h1>
    <div>
        <p><a href="/visitka/admin/id/1">О компании</a></p>
        <p><a href="/visitka/admin/id/2">Контакты</a></p>
        <p><a href="/visitka/admin/id/3">Главная страница </a></p>
        <br/>
        <p><a href="/visitka/admin"><img src="images/add_btn.jpg" alt="добавить страницу"/></a></p>

        <p>Главная страница:</p>
        <form method="POST" action="/visitka/admin">
            <select name="home_page">
                <option value="1">О компании</option>
                <option value="2">Контакты</option>
                <option value="3" selected="">Главная страница</option>
            </select>
            <br>
            <input type="image" src="images/update_btn.jpg" name="home">
        </form>
        <br>
        <p>Страница контактов:</p>
        <form method="POST" action="/visitka/admin">
            <select name="contacts">
                <option value="1">О компании</option>
                <option value="2" selected="">Контакты</option>
                <option value="3">Главная страница</option>
            </select>
            <br>
            <input type="image" src="images/update_btn.jpg" name="contacts_submit">
        </form>
    </div>
</td>