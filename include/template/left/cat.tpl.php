<div class="left_list left_cat">
<h3>Thématiques :</h3>
<?php $page = page()->get('cat'); ?>
<ul>
<?php foreach (cat()->select('active=1') as $cat) { ?>
<li><?php echo $page->link($cat->id); ?></li>
<?php } ?>
</ul>
</div>

