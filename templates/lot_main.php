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
    <section class="lot-item container">
        <h2><?= esc($lot_card['name_lot']) ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= esc($lot_card['image']) ?>" width="730" height="548" alt="<?= esc($lot_card['name_lot']) ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= esc($lot_card['name_cat']) ?></span></p>
                <p class="lot-item__description"><?= esc($lot_card['description']) ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <?php list ($hours, $minutes) = difference_date($lot_card['dt_complete']); ?>
                    <div class="lot-item__timer timer <?php if ($hours < 1): ?> timer--finishing <?php endif ?>">
                        <?= esc($hours) ?>:<?= esc($minutes) ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= esc(price_format($lot_card['price_start'])) ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка: <span></span>
                        </div>
                    </div>
                    <!--Здесь будет форма-->
                </div>
                <!--Здесь будет история ставок-->
            </div>
        </div>
    </section>
</main>






