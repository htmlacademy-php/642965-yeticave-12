<main>
    <nav class="nav">
        <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item <?php if (getPostVal('cat_name') == $category['cat_name']): ?>nav__item--current<?php endif ?>">
                <a href="lot_cat.php?cat_name=<?= esc($category['cat_name']) ?>"><?= esc($category['cat_name']) ?></a>
            </li>
        <?php endforeach ?>
        </ul>
    </nav>
    <div class="container">
        <section class="lots">
            <h2>Все лоты в категории <span>«<?= esc(getPostVal('cat_name')) ?>»</span></h2>
            <ul class="lots__list">
            <?php foreach ($lots as $lot):
                list ($hours, $minutes) = difference_date($lot['dt_complete']);
            ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= esc($lot['image']) ?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= esc($lot['cat_name']) ?></span>
                        <h3 class="lot__title">
                            <a class="text-link" href="lot.php?id=<?= esc($lot['id']) ?>"><?= esc($lot['lot_name']) ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= esc(price_format($lot['price_start'])) ?></span>
                            </div>
                            <div class="lot__timer timer <?php if ($hours < 1): ?> timer--finishing <?php endif ?>">
                                <?= esc($hours) ?>:<?= esc($minutes) ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
            </ul>
        </section>
        <?php if ($pages_count > 1): ?>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev">
                <a <?php if ($current_page > 1): ?>href="lot_cat.php?cat_name=<?= esc(getPostVal('cat_name')) ?>&page=<?= esc($current_page - 1) ?>"<?php endif ?>>Назад</a>
            </li>
            <?php foreach ($pages as $page): ?>
            <li class="pagination-item <?php if ($page == $current_page): ?>pagination-item-active<?php endif ?>">
                <a href="lot_cat.php?cat_name=<?= esc(getPostVal('cat_name')) ?>&page=<?= $page ?>"><?= $page ?></a>
            </li>
            <?php endforeach ?>
            <li class="pagination-item pagination-item-next">
                <a <?php if ($current_page < $pages_count): ?>href="lot_cat.php?cat_name=<?= esc(getPostVal('cat_name')) ?>&page=<?= esc($current_page + 1) ?>"<?php endif ?>>Вперед</a>
            </li>
        </ul>
        <?php endif ?>
    </div>
</main>
