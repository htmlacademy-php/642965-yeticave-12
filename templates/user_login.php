<main>
    <nav class="nav">
        <nav class="nav">
            <ul class="nav__list container">
                <?php foreach ($categories as $value): ?>
                    <li class="nav__item">
                        <a href="all-lots.html"><?= esc($value['name_cat']) ?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </nav>
    </nav>
    <form class="form container" action="login.php" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item"> <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail">
            <span class="form__error">Введите e-mail</span>
        </div>
        <div class="form__item form__item--last">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">
            <span class="form__error">Введите пароль</span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
