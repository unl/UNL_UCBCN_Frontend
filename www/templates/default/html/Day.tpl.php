<div class="wdn-grid-set">
    <section class="bp2-wdn-col-one-third">
        <?php echo $savvy->render($context, 'sidebar.tpl.php'); ?>
    </section>
    <section id="updatecontent" class="day_cal bp2-wdn-col-two-thirds">
        <?php
        echo $savvy->render($context, 'hcalendar/Day.tpl.php');
        ?>
    </section>
</div>
