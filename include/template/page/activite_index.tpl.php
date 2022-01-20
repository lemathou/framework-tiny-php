<h1><?php echo $this->page->titre; ?></h1>

<?php $page = page()->get(11); ?>
<div class="activite_list content_list">
<?php foreach (activite()->select('active=1', 10) as $activite){ ?>
<div class="activite content_link">
<h3 style="margin-right: 200px;"><?php echo $page->link($activite->id); ?></h3>
<div><?php echo $activite->resume; ?></div>
</div>
<?php } ?>
</div>
