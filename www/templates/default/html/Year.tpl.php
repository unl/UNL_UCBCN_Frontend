<h1 class="year_main"><?php echo $context->year; ?></h1>
<div class="year_cal">
<table>
<tr>
<td>
<?php echo $savvy->render($context->monthwidgets[0]); ?>
</td>
<td>
<?php echo $savvy->render($context->monthwidgets[1]); ?>
</td>
<td>
<?php echo $savvy->render($context->monthwidgets[2]); ?>
</td>
</tr>
<tr>
<td>
<?php echo $savvy->render($context->monthwidgets[3]); ?>
</td>
<td>
<?php echo $savvy->render($context->monthwidgets[4]); ?>
</td>
<td>
<?php echo $savvy->render($context->monthwidgets[5]); ?>
</td>
</tr>
<tr>
<td>
<?php echo $savvy->render($context->monthwidgets[6]); ?>
</td>
<td>
<?php echo $savvy->render($context->monthwidgets[7]); ?>
</td>
<td>
<?php echo $savvy->render($context->monthwidgets[8]); ?>
</td>
</tr>
<tr>
<td>
<?php echo $savvy->render($context->monthwidgets[9]); ?>
</td>
<td>
<?php echo $savvy->render($context->monthwidgets[10]); ?>
</td>
<td>
<?php echo $savvy->render($context->monthwidgets[11]); ?>
</td>
</tr>
</table>
</div>