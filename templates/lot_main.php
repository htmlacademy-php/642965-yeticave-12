<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="lot_cat.php?cat_name=<?= esc($category['cat_name']) ?>"><?= esc($category['cat_name']) ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2><?= esc($lotCard['lot_name']) ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= esc($lotCard['image']) ?>" width="730" height="548"
                         alt="<?= esc($lotCard['lot_name']) ?>">
                </div>
                <p class="lot-item__category">
                    <span>Автор лота: <?= esc($lotCard['user_name']) ?></span><br>
                    <span>Категория: <?= esc($lotCard['cat_name']) ?></span>
                </p>
                <p class="lot-item__description"><?= esc($lotCard['description']) ?></p>
            </div>
            <div class="lot-item__right">
                <?php list ($hours, $minutes) = differenceDate($lotCard['dt_complete']); ?>
                <div class="lot-item__state">
                    <div class="lot-item__timer timer <?php if ($hours < 1) echo "timer--finishing" ?><?php if (lastMinute($lotCard['dt_complete'])) echo " timer--last-minute" ?>">
                        <?= esc($hours) ?>:<?= esc($minutes) ?>
                        <?php if (lastMinute($lotCard['dt_complete'])) echo "последняя минута"?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= esc(priceFormat($currentPrice)) ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка: <span><?= esc(priceFormat($currentPrice + $lotCard['bid_step'])) ?></span>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['name']) && ($_SESSION['id'] != $lotCard['user_id']) && ((diffDateComplete($lotCard['dt_complete']) > 0))):
                        if ($_SESSION['id'] != ($bets['0']['user_id'] ?? '0')):
                            ?>
                            <form class="lot-item__form" action="lot.php?id=<?= $lotCard['id'] ?>&success=true"
                                  method="post" autocomplete="off">
                                <p class="lot-item__form-item <?php if (!empty($errors)): ?>form__item form__item--invalid<?php endif ?>">
                                    <label for="cost">Ваша ставка</label>
                                    <input id="cost" type="text" name="cost" value="<?= esc(getPostVal('cost')) ?>" placeholder="12500">
                                    <span class="form__error"><?= esc($errors['step'] ?? "") ?></span>
                                </p>
                                <button type="submit" class="button">Сделать</button>
                            </form>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="history">
                    <h3>История ставок (<span><?= esc($betsCount) ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($bets as $bet): ?>
                            <tr class="history__item">
                                <td class="history__name"><?= esc($bet['name']) ?></td>
                                <td class="history__price"><?= esc($bet['price']) ?></td>
                                <td class="history__time"><?= esc(pastDate($bet['dt_create'])) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>






