<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $value): ?>
                <li class="nav__item">
                    <a href="index.php"><?= esc($value['cat_name']) ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </nav>
    <form class="form form--add-lot container <?php if (count($errors)): ?>form--invalid<?php endif ?>" action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="post" enctype="multipart/form-data">
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <?php $classname = isset($errors['lot-name']) ? "form__item--invalid" : ""; ?>
            <div class="form__item <?= $classname ?>">
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= esc(getPostVal('lot-name')) ?>">
                <span class="form__error"><?= esc($errors['lot-name'] ?? ""); ?></span>
            </div>
            <?php $classname = isset($errors['category']) ? "form__item--invalid" : ""; ?>
            <div class="form__item <?= $classname ?>">
                <label for="category_id">Категория <sup>*</sup></label>
                <select id="category_id" name="category">
                    <option>Выбрать</option>
                    <?php foreach ($categories as $value): ?>
                    <option value="<?= esc($value['id']) ?>"<?php if ($value['id'] == getPostVal('category')): ?> selected <?php endif; ?>><?= esc($value['cat_name']) ?></option>
                    <?php endforeach ?>
                </select>
                <span class="form__error"><?= esc($errors['category'] ?? ""); ?></span>
            </div>
        </div>
        <?php $classname = isset($errors['message']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--wide <?= $classname ?>">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите описание лота"><?= esc(getPostVal('message')) ?></textarea>
            <span class="form__error"><?= esc($errors['message'] ?? ""); ?></span>
        </div>
        <?php $classname = isset($errors['file']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--file <?= $classname ?>">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="lot-img" name="file_img" value="">
                <label for="lot-img">
                    Добавить
                </label>
                <span class="form__error"><?= esc($errors['file'] ?? ""); ?></span>
            </div>
        </div>
        <div class="form__container-three">
            <?php $classname = isset($errors['lot-rate']) ? "form__item--invalid" : ""; ?>
            <div class="form__item form__item--small <?= $classname ?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= esc(getPostVal('lot-rate')) ?>">
                <span class="form__error"><?= esc($errors['lot-rate'] ?? ""); ?></span>
            </div>
            <?php $classname = isset($errors['lot-step']) ? "form__item--invalid" : ""; ?>
            <div class="form__item form__item--small <?= $classname ?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= esc(getPostVal('lot-step')) ?>">
                <span class="form__error"><?= esc($errors['lot-step'] ?? ""); ?></span>
            </div>
            <?php $classname = isset($errors['lot-date']) ? "form__item--invalid" : ""; ?>
            <div class="form__item <?= $classname ?>">
                <label for="lot-date1">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date1" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= esc(getPostVal('lot-date')) ?>" >
                <span class="form__error"><?= esc($errors['lot-date'] ?? ""); ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме!</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
