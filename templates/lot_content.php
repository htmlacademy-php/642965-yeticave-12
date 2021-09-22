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
        <?= $lot_content_right ?>
    </div>
</section>
