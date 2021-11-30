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
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
        <?php foreach ($my_bets as $my_bet):
              list ($hours, $minutes) = difference_date($my_bet['dt_complete']);
        ?>
            <tr class="rates__item <?php if (($hours == 0) && ($minutes == 0)): ?>rates__item--end<?php endif ?>"><!-- rates__item--win - ставка выиграла -->
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= esc($my_bet['image']) ?>" width="54" height="40" alt="<?= esc($my_bet['lot_name']) ?>">
                    </div>
                    <div>
                        <h3 class="rates__title">
                            <a href="lot.php?id=<?= esc($my_bet['id']) ?>"><?= esc($my_bet['lot_name']) ?></a>
                        </h3>
                        <!-- <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p> - добавить абцаз с подробной инфой если ставка выиграла -->
                    </div>
                </td>
                <td class="rates__category">
                    <?= esc($my_bet['cat_name']) ?>
                </td>
                <td class="rates__timer">
                    <div class="timer <?= timerClass($hours, $minutes) ?>"> <!-- timer--win - Ставка выиграла -->
                        <?= esc(timerResult($hours, $minutes)) ?>
                    </div>
                </td>
                <td class="rates__price">
                    <?= esc(price_format($my_bet['price'])) ?>
                </td>
                <td class="rates__time">
                    <?= esc(pastDate($my_bet['dt_create'])) ?>
                </td>
            </tr>
        <?php endforeach ?>
        </table>
    </section>
</main>
