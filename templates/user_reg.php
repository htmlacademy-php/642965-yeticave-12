<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $value): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= esc($value['name_cat']) ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </nav>
    <form class="form container <?php if (count($errors)): ?>form--invalid<?php endif ?>" action="reg.php" method="post" autocomplete="off">
        <h2>Регистрация нового аккаунта</h2>
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname ?>">
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= esc(getPostVal('email')) ?>">
            <span class="form__error"><?= esc($errors['email'] ?? ""); ?></span>
        </div>
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= esc(getPostVal('password')) ?>">
            <span class="form__error"><?= esc($errors['password'] ?? ""); ?></span>
        </div>
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname ?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= esc(getPostVal('name')) ?>">
            <span class="form__error"><?= esc($errors['name'] ?? ""); ?></span>
        </div>
        <?php $classname = isset($errors['message']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname ?>">
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= esc(getPostVal('message')) ?></textarea>
            <span class="form__error"><?= esc($errors['message'] ?? ""); ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>
