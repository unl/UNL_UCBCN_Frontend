<div class="wdn-grid-set">
    <aside class="bp2-wdn-col-one-third">
        <?php echo $savvy->render($context, 'sidebar.tpl.php'); ?>
    </aside>
    <section id="updatecontent" class="day_cal bp2-wdn-col-two-thirds">
        <?php echo $savvy->render($context, 'hcalendar/Day.tpl.php'); ?>
    </section>
</div>
