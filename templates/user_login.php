<main>
    <nav class="nav">
        <nav class="nav">
            <ul class="nav__list container">
                <?php foreach ($categories as $category): ?>
                    <li class="nav__item">
                        <a href="lot_cat.php?cat_name=<?= esc($category['cat_name']) ?>"><?= esc($category['cat_name']) ?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </nav>
    </nav>
    <form class="form container <?php if (count($errors)): ?>form--invalid<?php endif; ?>" action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="post">
        <h2>Вход</h2>
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname ?>">
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= esc(getPostVal('email')) ?>">
            <span class="form__error"><?= esc($errors['email'] ?? "") ?></span>
        </div>
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--last <?= $classname ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= esc(getPostVal('password')) ?>">
            <span class="form__error"><?= esc($errors['password'] ?? "") ?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
