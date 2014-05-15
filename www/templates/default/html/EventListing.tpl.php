<table>
    <thead>
        <tr>
            <th scope="col" class="date">Time</th>
            <th scope="col" class="title">Event Title</th>
        </tr>
    </thead>
    <tbody class="vcalendar">
        <?php
        foreach ($context as $eventinstance) {
            //Start building an array of row classes
            $row_classes = array('vevent');

            if ($eventinstance->isAllDay()) {
                $row_classes[] = 'all-day';
            }

            if ($eventinstance->isInProgress()) {
                $row_classes[] = 'in-progress';
            }

            if ($eventinstance->isOnGoing()) {
                $row_classes[] = 'ongoing';
            }

            ?>
            <tr class="<?php echo implode(' ', $row_classes) ?>">
                <td class="date">
                    <?php echo $savvy->render($eventinstance, 'EventInstance/Date.tpl.php') ?>
                </td>
                <td>
                    <?php echo $savvy->render($eventinstance, 'EventInstance/Summary.tpl.php') ?>
                    <?php echo $savvy->render($eventinstance, 'EventInstance/Location.tpl.php') ?>
                    <?php echo $savvy->render($eventinstance, 'EventInstance/Description.tpl.php') ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

