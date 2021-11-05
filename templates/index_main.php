<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($categories as $value): ?>
                <li class="promo__item promo__item--<?= esc($value['symbol']) ?>">
                    <a class="promo__link" href="index.php"><?= esc($value['cat_name']) ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($product_card as $value):
                list ($hours, $minutes) = difference_date($value['dt_complete']);
            ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= esc($value['image']) ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= esc($value['cat_name']) ?></span>
                    <h3 class="lot__title">
                        <a class="text-link" href="lot.php?id=<?= esc($value['id']) ?>"><?= esc($value['lot_name']) ?></a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= esc(price_format($value['price_start'])) ?></span>
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
</main>
