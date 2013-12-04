<table>
    <thead>
        <tr>
            <th scope="col" class="date">Time</th>
            <th scope="col" class="title">Event Title</th>
        </tr>
    </thead>
    <tbody class="vcalendar">
        <?php
        $oddrow = false;
        foreach ($context as $eventinstance) {
            //Start building an array of row classes
            $row_classes = array('vevent');
        
            if ($oddrow) {
                //Add an alt class to odd rows
                $row_classes[] = 'alt';
            }
        
            //Invert oddrow
            $oddrow = !$oddrow;
        
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

