<div class="wdn-grid-set">
    <section class="bp1-wdn-col-one-third">
        <div class="calendar">
            <?php echo $savvy->render($context->getMonthWidget()); ?>
        </div>
    </section>
    <section id="updatecontent" class="day_cal bp1-wdn-col-two-thirds">
        <?php
        echo $savvy->render($context, 'hcalendar/Day.tpl.php');
        ?>
    </section>
</div>
