<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($categories as $value): ?>
                <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="pages/all-lots.html"><?= esc($value) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($product_card as $value):
                $result_time_arr = difference_date($value['lot_expiration_date']); //функция вернула остаток времени [часы, минуты]
                $result_time = $result_time_arr[0] . ":" . $result_time_arr[1];
            ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= esc($value['url_image']) ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= esc($value['category']) ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= esc($value['name']) ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= esc(price_format($value['price'])) ?></span>
                        </div>
                        <div class="lot__timer timer <?php if ($result_time_arr[0] < 1) {echo 'timer--finishing';} ?>">
                        <?php echo esc($result_time) ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>