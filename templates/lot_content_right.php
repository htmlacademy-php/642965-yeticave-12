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
    </div>
</div>
