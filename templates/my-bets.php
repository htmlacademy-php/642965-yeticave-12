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
        <?php foreach ($myBets as $myBet):
              list ($hours, $minutes) = differenceDate($myBet['dt_complete']);
        ?>
            <tr class="rates__item <?= ratesItemClass($hours, $minutes, $userId, $myBet['user_winner_id']) ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= esc($myBet['image']) ?>" width="54" height="40" alt="<?= esc($myBet['lot_name']) ?>">
                    </div>
                    <div>
                        <h3 class="rates__title">
                            <a href="lot.php?id=<?= esc($myBet['id']) ?>"><?= esc($myBet['lot_name']) ?></a>
                        </h3>
                        <p><?php if ($userId == $myBet['user_winner_id']) echo $myBet['contacts'] ?></p>
                    </div>
                </td>
                <td class="rates__category">
                    <?= esc($myBet['cat_name']) ?>
                </td>
                <td class="rates__timer">
                    <div class="timer <?= timerClass($hours, $minutes, $userId, $myBet['user_winner_id']) ?>">
                        <?= esc(timerResult($hours, $minutes, $userId, $myBet['user_winner_id'])) ?>
                    </div>
                </td>
                <td class="rates__price">
                    <?= esc(priceFormat($myBet['priceMax'])) ?>
                </td>
                <td class="rates__time">
                    <?= esc(pastDate($myBet['dtCreate'])) ?>
                </td>
            </tr>
        <?php endforeach ?>
        </table>
    </section>
</main>
