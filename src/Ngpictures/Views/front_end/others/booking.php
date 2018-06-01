<?php include(APP . "/Views/includes/menu.php"); ?>
<section class="section container row">
    <h2 class="ui header" style="margin-top: 20px">
        <strong>Mois de <?= $current_month ?></strong>
    </h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, at odio, consequatur magnam necessitatibus minus totam quo accusamus inventore aliquam voluptates, mollitia modi. Porro, mollitia rem nihil hic nesciunt maiores.</p>
    <span class="right">
        <a href="/booking?m=<?= $previousMonth ?>&y=<?= $previousYear ?>" class="btn">Précédent</a>
        <a href="/booking?m=<?= $nextMonth ?>&y=<?= $nextYear ?>" class="btn">Suivant</a>
    </span>
</section>
<section class="section jumbotron dark calendar">
    <div class="container">
        <table class="calendar__table calendar__table--<?= $weeks ?>weeks responsive-table">
        <?php for ($i = 0; $i < $weeks; $i++) : ?>
            <tr>
                <?php
                foreach ($days as $k => $day) :
                    $date = (clone $start)->modify("+" . ($k + $i * 7) . "days");
                $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                ?>
                    <td class="<?= $calendar->withInMonth($date) ? '' : 'calendar__othermonth' ?>">
                        <?php if ($i === 0) : ?>
                            <div class="calendar__weekday"><?= $day ?></div>
                        <?php endif; ?>

                        <div class="calendar__day"><?= $date->format('d') ?><div>
                        <?php foreach ($eventsForDay as $event) : ?>
                            <div class="calendar__event">
                                <?= (new DateTime($event['started']))->format('H:i'); ?> -
                                <a href="events/<?= $event['id'] ?>"><?= $event['name']; ?></a>
                            </div>
                        <?php endforeach; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor; ?>
    </table>
    </div>
</section>
